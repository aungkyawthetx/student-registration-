<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->paginate(5);
        return view('admin.enrollment.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('admin.enrollment.create',compact('students', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'enrollment_date' => 'required'
        ]);

        Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'date' => $request->enrollment_date,
        ]);

        return redirect()->route('enrollments.index')->with('successAlert', 'Enrollment created successfully.');
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
        $students = Student::all();
        $courses = Course::all();
        $enrollment = Enrollment::find($id);
        return view('admin.enrollment.edit', compact('students', 'courses', 'enrollment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'student_name' => 'required',
            'course_name' => 'required',
            'enrollment_date' => 'required'
        ]);

        $enrollment = Enrollment::find($id);
        $enrollment->update([
            'student_id' => $request->student_name,
            'course_id' => $request->course_name,
            'date' => $request->enrollment_date,
        ]);
        return redirect()->route('enrollments.index')->with('successAlert', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::find($id);
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('successAlert', 'One row deleted.');
    }
}
