<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate input with custom error messages
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);

        // Check if user exists
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address. Please check your email or register for a new account.',
            ])->withInput($request->except('password'));
        }

        // Attempt authentication
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Log successful user login
            \Log::info('User login successful', [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended('/')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Log failed login attempt
        \Log::warning('Failed login attempt', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'password' => 'The password you entered is incorrect. Please check your password and try again.',
        ])->withInput($request->except('password'));
    }

    public function adminLogin(Request $request)
    {
        // Validate input with custom error messages
        $credentials = $request->validate([
            'email'    => ['required', 'email', 'regex:/^.+\.com$/'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Admin email address must end with .com domain.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);

        // Check if user exists
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address. Please check your email or contact an administrator.',
            ])->withInput($request->except('password'));
        }

        // Check if user is an admin
        if (!$user->is_admin) {
            return back()->withErrors([
                'email' => 'Access denied. This account does not have admin privileges. Please contact an administrator.',
            ])->withInput($request->except('password'));
        }

        // Attempt authentication
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Double-check admin status after authentication
            if (Auth::user()->is_admin) {
                // Log successful admin login
                \Log::info('Admin login successful', [
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            } else {
                // This shouldn't happen, but just in case
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Admin access has been revoked. Please contact an administrator.',
                ])->withInput($request->except('password'));
            }
        }

        // Log failed login attempt
        \Log::warning('Failed admin login attempt', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'password' => 'The password you entered is incorrect. Please check your password and try again.',
        ])->withInput($request->except('password'));
    }

    /**
     * Show the regular login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the admin login form
     */
    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        // Log the logout activity
        if (Auth::check()) {
            \Log::info('User logout', [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Log the admin out of the application.
     */
    public function adminLogout(Request $request)
    {
        // Log the admin logout activity
        if (Auth::check()) {
            \Log::info('Admin logout', [
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Admin logged out successfully.');
    }
}
