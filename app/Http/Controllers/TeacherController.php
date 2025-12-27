<?php

namespace App\Http\Controllers;

use App\Exports\TeachersExport;
use App\Imports\TeachersImport;
use App\Models\Course;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $teachers = Teacher::paginate(5);
        return view('admin.teachers.index', compact('teachers','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        try{
            $request->validate([
                'name'=>'required|string|max:50',
                'email'=>'required|string|email|max:50',
                'phone'=>'required|string|max:30',
            ]);
    
            Teacher::create([
                'name' => $request->name, 
                'email' =>  $request->email, 
                'phone' => $request->phone,
            ]);
            return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
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
        $teacher = Teacher::with('courses')->findOrFail($id);
        return view('admin.details.teacherdetails', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Gate::denies('update', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher = Teacher::find($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name'=>'required|string|max:50',
            'email'=>'required|string|email|max:50',
            'phone'=>'required|string|max:30',
        ]);

        $teacher = Teacher::find($id);
        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
        try{
            $request->validate([
                'name'=>'required|string|max:50',
                'subject'=>'required|string|max:50',
                'email'=>'required|string|email|max:50',
                'phone'=>'required|string|max:30',
            ]);
    
            $teacher = Teacher::find($id);
            $teacher->update($request->all());
    
            return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
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
        if (Gate::denies('delete', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher = Teacher::find($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teachers = Teacher::all();
        if ($teachers->isEmpty()) {
            return redirect()->route('teachers.index')->with('error', 'No teachers to delete.');
        }
        foreach ($teachers as $teacher) {
            $teacher->delete();
        }
        return redirect()->route('teachers.index')->with('success','All teachers deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('teachers.index');
        } else {
            $teachers = Teacher::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->orWhere('email','LIKE','%'.$searchData.'%')
            ->orWhere('subject','LIKE','%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.teachers.index', compact('teachers','roles'));
        }
    }

    public function export(){
        return Excel::download(new TeachersExport(),'teachers.xlsx');
    }

    public function import(Request $request){
        $request->validate(['teachers'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('teachers');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'teachers')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "teachers"');
        }
        try {
            Excel::import(new TeachersImport(), $request->file('teachers'));
            return redirect()->route('teachers.index')->with('success', 'Teachers imported successfully!');
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
