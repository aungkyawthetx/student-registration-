<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\ClassTimeTable;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassTimeTable::with('room')->paginate(5);
        return view('admin.class.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('admin.class.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
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
        $rooms = Room::all();
        $class = ClassTimeTable::find($id);
        return view('admin.class.edit', compact('class', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|integer',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
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
        $class = ClassTimeTable::find($id);

        if ($class) {
            $class->delete();
            return redirect()->route('classes.index')->with('successAlert', 'One row deleted.');
        }
        return redirect()->route('classes.index')->with('errorAlert', 'Class Not Found!');
    }
}
