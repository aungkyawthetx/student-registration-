<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teachers = Teacher::paginate(5);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
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
        if (Gate::denies('update', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher = Teacher::find($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
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
        if (Gate::denies('delete', Teacher::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $teacher = Teacher::find($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

    public function search(Request $request){
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('teachers.index');
        } else {
            $teachers = Teacher::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->orWhere('email','LIKE','%'.$searchData.'%')
            ->orWhere('subject','LIKE','%'.$searchData.'%')
            ->paginate(5);
            return view('admin.teachers.index', compact('teachers'));
        }
    }
}
