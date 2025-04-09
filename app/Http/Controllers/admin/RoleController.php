<?php

namespace App\Http\Controllers\admin;

use App\Exports\RolesExport;
use App\Http\Controllers\Controller;
use App\Imports\RolesImport;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::paginate(5);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name'=> 'required|max:50',
            'description'=>'required|string|max:100',
        ]);

        Role::create($request->all());
        return redirect()->route('roles.index')->with('success','Role created successfully.');
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
        if (Gate::denies('update', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $role = Role::find($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name'=> 'required|max:50',
            'description'=>'required|string|max:100',
        ]);
        $role = Role::find($id);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('success','Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success','Role deleted successfully.');
    }

    public function destroyall()
    {
        if (Gate::denies('delete', Role::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        if ($roles->isEmpty()) {
            return redirect()->route('roles.index')->with('error', 'No roles to delete.');
        }
        foreach ($roles as $role) {
            $role->delete();
        }
        return redirect()->route('roles.index')->with('success','All roles deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('roles.index');
        } else {
            $roles =Role::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->paginate(5)
            ->appends(['search_data' => $search]);
            return view('admin.roles.index', compact('roles'));
        }
    }

    public function export(){
        return Excel::download(new RolesExport(),'roles.xlsx');
    }

    public function import(Request $request){
        $request->validate(['roles'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('roles');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'roles')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "roles"');
        }
        try {
            Excel::import(new RolesImport(), $request->file('roles'));
            return redirect()->route('roles.index')->with('success', 'Roles imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format.');
        }
    }
}
