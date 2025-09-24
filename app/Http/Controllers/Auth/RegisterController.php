<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'max:255'
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => [
                'required',
                'string',
                'regex:/^\+62[0-9]{8,13}$/'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Full name is required.',
            'name.regex' => 'Full name can only contain letters and spaces.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must start with +62 and contain only numbers (e.g., +62812345678).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect('/');
    }
}