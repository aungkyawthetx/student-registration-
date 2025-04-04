<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::paginate(5);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.teachers.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:50',
            'course'=>'required|string|max:50',
            'email'=>'required|string|email|max:50',
            'phone'=>'required|string|max:30',
        ]);

        Teacher::create([
            'name' => $request->name, 
            'subject' => $request->course, 
            'email' =>  $request->email, 
            'phone' => $request->phone,
        ]);
        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
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
        $teacher = Teacher::find($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|string|max:50',
            'subject'=>'required|string|max:50',
            'email'=>'required|string|email|max:50',
            'phone'=>'required|string|max:30',
        ]);

        $teacher = Teacher::find($id);
        $teacher->update($request->all());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::find($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'One row deleted.');
    }
}
