<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if the authenticated user is an admin
            $temp = Auth::user()->is_admin;

            if ($temp) {
                // Redirect admin to the admin dashboard

                return redirect()->intended('/admin/dashboard');
            }

            // Redirect regular users to the default intended location (e.g., home)
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Please check your credentials and try again.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
