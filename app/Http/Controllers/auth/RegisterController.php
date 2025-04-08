<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:50|unique:users,name',
            'email'=> 'required|string|email|max:50|unique:users,email',
            'password'=> 'required|string|min:8|max:50|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ],[
            'password.regex' => 'The password must contain at least one letter and one number.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => '3',
        ]);
        return redirect()->route('login')->with('success','Account created successfully. Login here.');
    }
}
