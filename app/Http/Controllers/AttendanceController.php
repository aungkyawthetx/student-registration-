<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Room;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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
        // Eager load necessary relationships
        $classes = ClassTimeTable::with(['course'])->get();
        return view('admin.attendance.create', compact('classes'));
    }

    public function getStudentByClass($classId)
    {
        $class = ClassTimeTable::with('students')->findOrFail($classId);
        return response()->json($class->students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
    
        $validatedData = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $class = ClassTimeTable::find($request->class_id);
    
                    if (!$class) {
                        return $fail('The selected class does not exist.');
                    }
    
                    $startDate = Carbon::parse($class->start_date)->toDateString();
                    $endDate = Carbon::parse($class->end_date)->toDateString();
                    $attendanceDate = Carbon::parse($value)->toDateString();
    
                    if ($attendanceDate < $startDate || $attendanceDate > $endDate) {
                        $fail("The attendance date must be between {$startDate} and {$endDate}.");
                    }
                },
            ],
            'status' => 'required|in:P,A,L',
        ]);
    
        $student = Student::findOrFail($validatedData['student_id']);
    
        // Check if student is enrolled in the selected class
        if (!$student->classes()->where('classes.id', $validatedData['class_id'])->exists()) {
            return redirect()->back()->withErrors([
                'class_id' => 'The selected class is not enrolled by the student.',
            ])->withInput();
        }
    
        // Check for duplicate attendance
        $alreadyExists = Attendance::where('student_id', $validatedData['student_id'])
            ->where('class_id', $validatedData['class_id'])
            ->where('attendance_date', $validatedData['date'])
            ->exists();
    
        if ($alreadyExists) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Attendance for this student in this class on this date has already been recorded.',
            ])->withInput();
        }
    
        // Store attendance
        Attendance::create([
            'class_id' => $validatedData['class_id'],
            'student_id' => $validatedData['student_id'],
            'attendance_date' => $validatedData['date'],
            'attendance_status' => $validatedData['status'],
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
        $classes = ClassTimeTable::all();
        return view('admin.attendance.edit', compact('attendance', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Attendance::class)) {
            return redirect()->route('admin.dashboard')->with('error', 'No permission.');
        }
        try{
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
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This entry already exists in the database.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format. Ensure there are no duplicated rows.');
        }
    }
}
