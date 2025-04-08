<?php

namespace App\Http\Controllers;

use App\Exports\TeacherCoursesExport;
use App\Imports\TeacherCoursesImport;
use App\Models\Course;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherCourse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class TeacherCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $teacher_courses = TeacherCourse::with(['teacher', 'course'])->paginate(5);
        return view('admin.teacher_course.index', compact('teacher_courses', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teachers = Teacher::all();
        $courses = Course::all();
        return view('admin.teacher_course.create', compact('teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
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
        if (Gate::denies('update', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
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
        if (Gate::denies('update', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
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
        if (Gate::denies('delete', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher_course = TeacherCourse::find($id);
        $teacher_course->delete();
        return redirect()->route('teachercourses.index')->with('success', 'One row Deleted!');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', TeacherCourse::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher_courses = TeacherCourse::all();
        if ($teacher_courses->isEmpty()) {
            return redirect()->route('teachercourses.index')->with('error', 'No teacher courses to delete.');
        }
        foreach ($teacher_courses as $teacher_course) {
            $teacher_course->delete();
        }
        return redirect()->route('teachercourses.index')->with('success','All teacher courses deleted successfully.');
    }

    public function search(Request $request){
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('teachercourses.index');
        } else {
            $teachercourses = TeacherCourse::whereHas('course', function($courses) use ($searchData){
                $courses->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhereHas('teacher', function($teachers) use ($searchData){
                $teachers->where('name','LIKE','%'.$searchData.'%');
            })
            ->paginate(5);
            $roles = Role::all();
            return view('admin.teacher_course.index', compact('teachercourses', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new TeacherCoursesExport(),'teachercourses.xlsx');
    }

    public function import(Request $request){
        $request->validate(['teachercourses'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('teachercourses');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'teachercourses')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "teachercourses"');
        }
        try {
            Excel::import(new TeacherCoursesImport(), $request->file('teachercourses'));
            return redirect()->route('teachercourses.index')->with('success', 'Teacher courses imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format.');
        }
    }
}
