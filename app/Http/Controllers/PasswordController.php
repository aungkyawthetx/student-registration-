<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ForgotPassMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function forgotPass(Request $request){
        return view('auth.forgot-password');
    }

    public function resetPass(Request $request){
        $request->validate(['email' => 'required|email']);
        $count = User::where('email', '=',$request->email)->count();
        if($count > 0){
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => Hash::make($token), 'created_at' => now()]
            );
            Mail::to($request->email)->send(new ForgotPassMail($request->email, $token));
            return redirect()->route('login')->with('success','A reset password mail has been sent to your mail.');
        } else {
            return redirect()->back()->with('error','A user with this email is not found.');
        }
    }

    public function changePass($token){
        return view('auth.change-pass', ['token'=> $token]);
    }

    public function storePass(Request $request){
        $request->validate([
            'password'=> 'required|string|min:8|max:50|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:password',
            'email' => 'required|email',
            'token' => 'required',
        ]);
        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Invalid or expired token.');
        }
 
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return redirect()->route('login')->with('success', 'Password reset successfully. You can now log in.');
    }

    public function ChangePassword(string $id){
        $user = User::find($id);
        $authUser = Auth::user();
        if ($authUser->role_id == 1 || ($authUser->role_id != 1 && $authUser->id == $id)) {
            return view('admin.passwords.reset-password', compact('user'));
        }
        return back()->with('error', 'You are not authorized to perform this action.');
    }

    public function StorePassword(Request $request,string $id){
        $user = User::find($id);
        $authUser = Auth::user();
        if ($authUser->role_id == 1 || ($authUser->role_id != 1 && $authUser->id == $id)) {
            $request->validate([
                'password' => 'required|string|min:8|max:50|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
                'confirm_password' => 'required|same:password',
            ]);

            if ($authUser->role_id != 1 && !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);
            session()->forget('password_verified');
            return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully.');
        }
    }

    public function verifyAndRedirect(Request $request){
        $request->validate([
            'password' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $authUser = Auth::user();

        if (Hash::check($request->password, $authUser->password)) {
            session(['password_verified' => true]);
            return redirect()->route('change-password', $request->user_id);
        }

        return redirect()->back()->with('error','Incorrect password.');
    }

}
