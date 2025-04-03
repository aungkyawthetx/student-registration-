<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $rooms = Room::paginate(5);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'building' => 'required|string|max:10',
            'name' => 'required|string|max:10',
        ]);

        Room::create($request->all());
        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
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
        if (Gate::denies('update', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $room = Room::find($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'building' => 'required|string|max:10',
            'name' => 'required|string|max:10',
        ]);

        $room = Room::find($id);
        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $room = Room::find($id);
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }

    public function search(Request $request){
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('rooms.index');
        } else {
            $rooms = Room::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('building','LIKE','%'.$searchData.'%')
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->paginate(5);
            return view('admin.rooms.index', compact('rooms'));
        }
    }
}
