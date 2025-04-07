<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(5);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'fees' => 'required',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
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
        if (Gate::denies('update', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $course = Course::find($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name' => 'required|string|max:50',
            'duration' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'fees' => 'required',
        ]);

        $course = Course::find($id);
        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('destroy', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function search(Request $request){
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('courses.index');
        } else {
            $courses =Course::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->paginate(5);
            return view('admin.courses.index', compact('courses'));
        }
    }
}
