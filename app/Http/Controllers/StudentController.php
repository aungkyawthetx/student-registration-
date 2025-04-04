<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(5);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
            'nrc' => 'required|string|max:20',
            'dob' => 'required|date',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:100',
            'parent_info' => 'required|string|max:100',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
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
        $student = Student::find($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
            'nrc' => 'required|string|max:20',
            'dob' => 'required|date',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:100',
            'parent_info' => 'required|string|max:100',
        ]);
        $student = Student::find($id);
        $student->update($request->all());
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $students = Student::find($id);
        $students->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
