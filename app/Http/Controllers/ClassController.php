<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Room;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Exports\ClassesExport;
use App\Imports\ClassesImport;
use App\Models\ClassTimeTable;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $classes = ClassTimeTable::with('room','course')->paginate(5);
        return view('admin.class.index', compact('classes', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $courses = Course::all();
        $rooms = Room::all();
        $courses = Course::all();
        return view('admin.class.create', compact('rooms','courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $validatedData = $request->validate([
            'course_id' => 'required|integer',
            'room_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'time' => 'required',
        ]);

        $classes = ClassTimeTable::create([
            'course_id' => $validatedData['course_id'],
            'room_id' => $validatedData['room_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'time' => $validatedData['time'],
        ]);
        return redirect()->route('classes.index')->with('successAlert', 'Class Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $class = ClassTimeTable::with(['course', 'students'])->findOrFail($id);
        return view('admin.details.classdetails', compact('class'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Gate::denies('update', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $rooms = Room::all();
        $courses = Course::all();
        $class = ClassTimeTable::find($id);
        return view('admin.class.edit', compact('class', 'rooms','courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $validatedData = $request->validate([
            'course_id' => 'required|integer',
            'room_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'time' => 'required',
        ]);

        $class = ClassTimeTable::find($id);
        $class->update([
            'course_id' => $validatedData['course_id'],
            'room_id' => $validatedData['room_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'time' => $validatedData['time'],
        ]);

        return redirect()->route('classes.index')->with('successAlert', 'Class Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $class = ClassTimeTable::find($id);

        if ($class) {
            $class->delete();
            return redirect()->route('classes.index')->with('successAlert', 'One row deleted.');
        }
        return redirect()->route('classes.index')->with('errorAlert', 'Class Not Found!');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $classes = ClassTimeTable::all();
        if ($classes->isEmpty()) {
            return redirect()->route('classes.index')->with('errorAlert','No classes to delete.');
        }
        foreach ($classes as $class) {
            $class->delete();
        }
        return redirect()->route('classes.index')->with('successAlert','All classes deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('classes.index');
        } else {
            $classes = ClassTimeTable::whereHas('room', function($rooms) use ($searchData){
                $rooms->where('name','LIKE','%'.$searchData.'%');
            })
            ->orwhereHas('course', function($courses) use ($searchData){
                $courses->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhere('start_date', 'LIKE', '%'.$searchData.'%')
            ->orWhere('time', 'LIKE', '%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.class.index', compact('classes', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new ClassesExport(),'classtimetables.xlsx');
    }

    public function import(Request $request){
        $request->validate(['classtimetables'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('classtimetables');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'classtimetables')) {
            return redirect()->back()->with('errorAlert', 'Excel file name must contain the word "classtimetables"');
        }
        try {
            Excel::import(new ClassesImport(), $request->file('classtimetables'));
            return redirect()->route('classes.index')->with('successAlert', 'Class timetables imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('errorAlert', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('errorAlert', 'Failed to import. Please check your Excel file format.');
        }
    }
}
