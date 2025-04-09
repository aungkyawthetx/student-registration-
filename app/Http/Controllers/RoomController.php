<?php

namespace App\Http\Controllers;

use App\Exports\RoomsExport;
use App\Imports\RoomsImport;
use App\Models\Role;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

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
        $roles = Role::all();
        $rooms = Room::paginate(5);
        return view('admin.rooms.index', compact('rooms','roles'));
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

    public function destroyall()
    {
        if (Gate::denies('delete', Room::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $rooms = Room::all();
        if ($rooms->isEmpty()) {
            return redirect()->route('rooms.index')->with('error', 'No rooms to delete.');
        }
        foreach ($rooms as $room) {
            $room->delete();
        }
        return redirect()->route('rooms.index')->with('success','All rooms deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('rooms.index');
        } else {
            $rooms = Room::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('building','LIKE','%'.$searchData.'%')
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.rooms.index', compact('rooms', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new RoomsExport(),'rooms.xlsx');
    }

    public function import(Request $request){
        $request->validate(['rooms'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('rooms');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'rooms')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "rooms"');
        }
        try {
            Excel::import(new RoomsImport(), $request->file('rooms'));
            return redirect()->route('rooms.index')->with('success', 'Rooms imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format.');
        }
    }
}
