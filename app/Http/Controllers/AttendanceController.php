<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('student', 'room')->paginate(5);
        return view('admin.attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        $rooms = Room::all();
        return view('admin.attendance.create', compact('students', 'courses', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required',
            'course_name' => 'required',
            'attendance_date' => 'required',
            'room_name' => 'required',
            'status' => 'required|in:P,A,L',
        ]);
        // dd($request->class_date);
        Attendance::create([
            'student_id' => $request->student_name,
            'course_id' => $request->course_name,
            'attendance_date' => $request->attendance_date,
            'room_id' => $request->room_name,
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
        $attendance = Attendance::find($id);
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_name' => 'required',
            'course_name' => 'required',
            'attendance_date' => 'required',
            'room_name' => 'required',
            'status' => 'required|in:P,A,L',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'student_id' => $request->student_name,
            'course_id' => $request->course_name,
            'attendance_date' => $request->attendance_date,
            'room_id' => $request->room_name,
            'attendance_status' => $request->status,
        ]);
        return redirect()->route('attendances.index')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'One row deleted!');
    }
}
