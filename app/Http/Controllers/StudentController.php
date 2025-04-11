<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $students = Student::paginate(5);
        return view('admin.students.index', compact('students', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        try{
            $request->validate([
                'name' => 'required|string|max:50',
                'gender' => 'required|string|max:10',
                'nrc' => 'required|string|max:20',
                'dob' => 'required|date|before:today',
                'email' => 'required|string|email|max:50',
                'phone' => 'required|string|max:30',
                'address' => 'required|string|max:100',
                'parent_info' => 'required|string|max:100',
            ]);
    
            Student::create($request->all());
    
            return redirect()->route('students.index')->with('success', 'Student added successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This entry already exists in the database.');
            }
    
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Gate::denies('update', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $student = Student::find($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        try{
            $request->validate([
                'name' => 'required|string|max:50',
                'gender' => 'required|string|max:10',
                'nrc' => 'required|string|max:20',
                'dob' => 'required|date|before:today',
                'email' => 'required|string|email|max:50',
                'phone' => 'required|string|max:30',
                'address' => 'required|string|max:100',
                'parent_info' => 'required|string|max:100',
            ]);
            $student = Student::find($id);
            $student->update($request->all());
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This entry already exists in the database.');
            }
    
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $students = Student::find($id);
        $students->delete();
        return redirect()->route('students.index')->with('success', 'One row deleted.');
    }
        
    public function destroyall()
    {
        if (Gate::denies('delete', Student::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $students = Student::all();
        if ($students->isEmpty()) {
            return redirect()->route('students.index')->with('error', 'No students to delete.');
        }
        foreach ($students as $student) {
            $student->delete();
        }
        return redirect()->route('students.index')->with('success','All students deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('students.index');
        } else {
            $students = Student::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('email','LIKE','%'.$searchData.'%')
            ->orWhere('nrc','LIKE','%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.students.index', compact('students', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new StudentsExport(),'students.xlsx');
    }

    public function import(Request $request){
        $request->validate(['students'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('students');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'students')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "students"');
        }
        try {
            Excel::import(new StudentsImport(), $request->file('students'));
            return redirect()->route('students.index')->with('success', 'Students imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This entry already exists in the database.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format. Ensure there are no duplicated rows.');
        }
    }
}
