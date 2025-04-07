<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminConfirmPass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();

        if ($authUser->role_id == 1) {
            if (!$request->session()->has('password_verified') || !session('password_verified')) {
                return redirect()->route('admin.dashboard')->with('error', 'You must enter your password first.');
            }
        }
        return $next($request);
    }
}
