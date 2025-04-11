<?php

namespace App\Http\Controllers;

use App\Exports\EnrollmentsExport;
use App\Imports\EnrollmentsImport;
use App\Models\ClassTimeTable;
use App\Models\Course;
use App\Models\Role;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $enrollments = Enrollment::with('student', 'class')->paginate(5);
        return view('admin.enrollment.index', compact('enrollments','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $students = Student::all();
        $classes = ClassTimeTable::all();
        return view('admin.enrollment.create',compact('students', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        try{
            $request->validate([
                'student_id' => 'required',
                'class_id' => 'required',
                'enrollment_date' => 'required'
            ]);
            $alreadyEnrolled = DB::table('enrollments')
                ->where('student_id', $request['student_id'])
                ->where('class_id', $request['class_id'])
                ->exists();
    
            if ($alreadyEnrolled) {
                return redirect()->back()->with('error', 'This student is already enrolled in the selected class.')->withInput();
            }
            Enrollment::create([
                'student_id' => $request->student_id,
                'class_id' => $request->class_id,
                'date' => $request->enrollment_date,
            ]);
    
            return redirect()->route('enrollments.index')->with('successAlert', 'Enrollment created successfully.');
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
        if (Gate::denies('update', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $students = Student::all();
        $classes = ClassTimeTable::all();
        $enrollment = Enrollment::find($id);
        return view('admin.enrollment.edit', compact('students', 'classes', 'enrollment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        try{
            $request->validate([
                'student_name' => 'required',
                'class_name' => 'required',
                'enrollment_date' => 'required'
            ]);
            $enrollment = Enrollment::find($id);
            $enrollment->update([
                'student_id' => $request->student_name,
                'class_id' => $request->class_name,
                'date' => $request->enrollment_date,
            ]);
            return redirect()->route('enrollments.index')->with('successAlert', 'Enrollment updated successfully.');
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
        if (Gate::denies('delete', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $enrollment = Enrollment::find($id);
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('successAlert', 'One row deleted.');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', Enrollment::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $enrollments = Enrollment::all();
        if ($enrollments->isEmpty()) {
            return redirect()->route('enrollments.index')->with('error', 'No enrollments to delete.');
        }
        foreach ($enrollments as $enrollment) {
            $enrollment->delete();
        }
        return redirect()->route('enrollments.index')->with('success','All enrollments deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('enrollments.index');
        } else {
            $enrollments = Enrollment::whereHas('class', function($classes) use ($searchData){
                $classes->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhereHas('student', function($students) use ($searchData){
                $students->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhere('date', 'LIKE', '%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.enrollment.index', compact('enrollments', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new EnrollmentsExport(),'enrollments.xlsx');
    }

    public function import(Request $request){
        $request->validate(['enrollments'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('enrollments');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'enrollments')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "enrollments"');
        }
        
        try {
            Excel::import(new EnrollmentsImport(), $request->file('enrollments'));
            return redirect()->route('enrollments.index')->with('successAlert', 'Enrollments imported successfully!');
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
