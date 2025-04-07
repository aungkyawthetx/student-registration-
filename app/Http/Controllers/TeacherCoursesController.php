<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherCourse;

class TeacherCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher_courses = TeacherCourse::with(['teacher', 'course'])->paginate(5);
        return view('admin.teacher_course.index', compact('teacher_courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        $courses = Course::all();
        return view('admin.teacher_course.create', compact('teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_name' => 'required',
            'course_name' => 'required',
        ]);

        TeacherCourse::create([
            'teacher_id' => $request->teacher_name,
            'course_id' => $request->course_name,
        ]);
        return redirect()->route('teachercourses.index')->with('success', 'Teacher Course assigned successfully.'); 
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
        $teachers = Teacher::all();
        $courses = Course::all();
        $teacher_course = TeacherCourse::find($id);
        return view('admin.teacher_course.edit', compact('teachers', 'courses', 'teacher_course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'teacher_name' => 'required|string|max:30',
            'course_name' => 'required|string|max:50',
        ]);
        $teacher_course = TeacherCourse::find($id);
        $teacher_course->update([
            'teacher_id' => $request->teacher_name, //value = id
            'course_id' => $request->course_name, //value = id
        ]);
        return redirect()->route('teachercourses.index')->with('success', 'TeacherCourse Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher_course = TeacherCourse::find($id);
        $teacher_course->delete();
        return redirect()->route('teachercourses.index')->with('success', 'One row Deleted!');
    }
}
