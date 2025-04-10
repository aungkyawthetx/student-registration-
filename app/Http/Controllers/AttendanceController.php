<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Imports\AttendancesImport;
use App\Models\Role;
use App\Models\Room;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ClassTimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $roles = Role::all();
        $attendances = Attendance::with('student', 'class')->paginate(5);
        return view('admin.attendance.index', compact('attendances','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $students = Student::all();
        $classes = ClassTimeTable::all();
        return view('admin.attendance.create', compact('students', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $validateData = $request->validate([
            'class_name' => 'required|exists:classes,id',
            'student_name' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:P,A,L',
        ]);
        $student = Student::findOrFail($validateData['student_name']);
        if (!$student->classes()->where('classes.id', $validateData['class_name'])->exists()) {
            return redirect()->back()->withErrors([
                'class_name' => 'The selected class is not enrolled by the student.',
            ])->withInput();
        }
        Attendance::create([
            'class_id' => $request->class_name,
            'student_id' => $request->student_name,
            'attendance_date' => $request->attendance_date,
            'attendance_status' => $request->status,
        ]);
        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
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
        if (Gate::denies('update', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $attendance = Attendance::find($id);
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $request->validate([
            'class_name' => 'required',
            'student_name' => 'required',
            'attendance_date' => 'required',
            'status' => 'required|in:P,A,L',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'class_id' => $request->class_name,
            'student_id' => $request->student_name,
            'attendance_date' => $request->attendance_date,
            'attendance_status' => $request->status,
        ]);
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $attendance = Attendance::find($id);
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'One row deleted.');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        $attendances = Attendance::all();
        if ($attendances->isEmpty()) {
            return redirect()->route('attendances.index')->with('error', 'No attendances to delete.');
        }
        foreach ($attendances as $attendance) {
            $attendance->delete();
        }
        return redirect()->route('attendances.index')->with('success','All attendances deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('attendances.index');
        } else {
            $attendances = Attendance::whereHas('student', function($students) use ($searchData){
                $students->where('name','LIKE','%'.$searchData.'%');
            })
            ->orwhereHas('class', function($query) use ($searchData){
                $query->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhere('attendance_date', 'LIKE', '%'.$searchData.'%')
            ->orWhere('attendance_status', 'LIKE', '%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.attendance.index', compact('attendances', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new AttendancesExport(),'attendances.xlsx');
    }

    public function import(Request $request){
        $request->validate(['attendances'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('attendances');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'attendances')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "attendances"');
        }
        try {
            Excel::import(new AttendancesImport(), $request->file('attendances'));
            return redirect()->route('attendances.index')->with('success', 'Attendances imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format.');
        }
    }
}
