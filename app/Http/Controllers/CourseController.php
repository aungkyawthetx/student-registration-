<?php

namespace App\Http\Controllers;

use App\Exports\CoursesExport;
use App\Imports\CoursesImport;
use App\Models\Course;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $courses = Course::paginate(5);
        return view('admin.courses.index', compact('courses', 'roles'));
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
            'fees' => 'required|numeric|min:0',
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
        if (Gate::denies('delete', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'One row deleted.');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', Course::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $classes = Course::all();
        if ($classes->isEmpty()) {
            return redirect()->route('courses.index')->with('errorAlert','No courses to delete.');
        }
        foreach ($classes as $class) {
            $class->delete();
        }
        return redirect()->route('courses.index')->with('success','All courses deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('courses.index');
        } else {
            $courses =Course::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.courses.index', compact('courses','roles'));
        }
    }

    public function export(){
        return Excel::download(new CoursesExport(),'courses.xlsx');
    }

    public function import(Request $request){
        $request->validate(['courses'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('courses');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'courses')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "courses"');
        }
        try {
            Excel::import(new CoursesImport(), $request->file('courses'));
            return redirect()->route('courses.index')->with('success', 'Courses imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format.');
        }
    }
}
