<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request){
        $request->validate([
            'email'=> 'required|string|email|max:50',
            'password'=> 'required|string|min:8|max:50|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ]);

        if(Auth::guard('web')->attempt([
            'email'=>$request->email,
            'password'=>$request->password])){
                return redirect()->intended(route('admin.dashboard'))->with('success','Logged in successfully.');
        } else {
            return redirect()->back()->withInput()->withErrors([
                'email'=> 'Invalid email or password.',
            ]);
        }
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','Logged out successfully.');
    }
}
