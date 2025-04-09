<?php

namespace App\Http\Controllers\admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('view', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $users = User::with('role')->paginate(5);
        return view("admin.users.index", compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('create', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        return view("admin.users.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('create', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name'=> 'required|string|max:50|unique:users,name',
            'email'=> 'required|string|email|max:50|unique:users,email',
            'password'=> 'required|string|min:8|max:50',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|exists:roles,id',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ]);
        return redirect()->route('users.index')->with('success','User created successfully.');
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
        if (Gate::denies('update', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $roles = Role::all();
        $user = User::find($id);
        return view("admin.users.edit", compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Gate::denies('update', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $request->validate([
            'name'=> 'required|string|max:50|unique:users,name,' . $id,
            'email'=> 'required|string|email|max:50|unique:users,email,' . $id,
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role,
        ]);;
        return redirect()->route('users.index')->with('success','User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('delete', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully.');
    }

    public function destroyall($id)
    {
        if (Gate::denies('delete', User::class)) {
            return redirect()->route("admin.dashboard")->with('error', 'No permission.');
        }
        $users = User::where('id', '!=', $id)->get();
        if ($users->isEmpty()) {
            return redirect()->route('users.index')->with('error','No users to delete.');
        }
        foreach ($users as $user) {
            $user->delete();
        }
        return redirect()->route('users.index')->with('success','All users except current account deleted successfully.');
    }

    public function search(Request $request){
        $search = $request->input('search_data');
        $searchData = $request->search_data;
        if($searchData == ""){
            return redirect()->route('users.index');
        } else {
            $users =User::where('name','LIKE',"%".$searchData."%")
            ->orWhere('id', '=',$searchData)
            ->orWhere('name','LIKE','%'.$searchData.'%')
            ->orWhere('email','LIKE','%'.$searchData.'%')
            ->orWhereHas('role', function($roles) use ($searchData){
                $roles->where('name','LIKE','%'.$searchData.'%');
            })
            ->paginate(5)
            ->appends(['search_data' => $search]);
            $roles = Role::all();
            return view('admin.users.index', compact('users', 'roles'));
        }
    }

    public function export(){
        return Excel::download(new UsersExport(),'users.xlsx');
    }

    public function import(Request $request){
        $request->validate(['users'=>'required|file|mimes:xlsx,xls,csv']);
        $file = $request->file('users');
        $originalName = $file->getClientOriginalName();

        if (!str_contains(strtolower($originalName), 'users')) {
            return redirect()->back()->with('error', 'Excel file name must contain the word "users"');
        }

        try {
            Excel::import(new UsersImport(), $request->file('users'));
            return redirect()->route('users.index')->with('success', 'Users imported successfully!');
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to import. Please check your Excel file format. Ensure usernames and emails are unique');
        }
    }
}
