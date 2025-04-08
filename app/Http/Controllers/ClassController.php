<?php

namespace App\Http\Controllers;

use App\Exports\ClassesExport;
use App\Imports\ClassesImport;
use App\Models\Role;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
        $classes = ClassTimeTable::with('room')->paginate(5);
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
        $rooms = Room::all();
        return view('admin.class.create', compact('rooms'));
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
            'room_id' => 'required|integer',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
            'date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $classes = ClassTimeTable::create([
            'room_id' => $validatedData['room_id'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'date' => $validatedData['date'],
            'end_date' => $validatedData['end_date'],
        ]);
        return redirect()->route('classes.index')->with('successAlert', 'Class Added!');
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
        if (Gate::denies('update', ClassTimeTable::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $rooms = Room::all();
        $class = ClassTimeTable::find($id);
        return view('admin.class.edit', compact('class', 'rooms'));
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
            'room_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
        ]);

        $class = ClassTimeTable::find($id);
        $class->update([
            'room_id' => $validatedData['room_id'],
            'date' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
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
            return redirect()->route('classes.index')->with('successAlert', 'Class Deleted!');
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
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('classes.index');
        } else {
            $classes = ClassTimeTable::whereHas('room', function($rooms) use ($searchData){
                $rooms->where('name','LIKE','%'.$searchData.'%');
            })
            ->orWhere('date', 'LIKE', '%'.$searchData.'%')
            ->orWhere('start_time', 'LIKE', '%'.$searchData.'%')
            ->orWhere('end_time', 'LIKE', '%'.$searchData.'%')
            ->paginate(5);
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
