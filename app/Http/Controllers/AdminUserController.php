<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Filter by admin status
        if ($request->has('is_admin') && $request->is_admin !== '') {
            $query->where('is_admin', $request->is_admin);
        }

        // Email verification filtering removed

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'max:255'
            ],
            'email' => 'required|string|email|max:255|unique:users',
            'username' => [
                'nullable',
                'string',
                'max:25',
                'unique:users',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+62[0-9]{8,13}$/'
            ],
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean'
        ], [
            'name.required' => 'Full name is required.',
            'name.regex' => 'Full name can only contain letters and spaces.',
            'username.max' => 'Username cannot exceed 25 characters.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'phone.regex' => 'Phone number must start with +62 and contain only numbers (e.g., +62812345678).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'max:255'
            ],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => [
                'nullable',
                'string',
                'max:25',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+62[0-9]{8,13}$/'
            ],
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean'
        ], [
            'name.required' => 'Full name is required.',
            'name.regex' => 'Full name can only contain letters and spaces.',
            'username.max' => 'Username cannot exceed 25 characters.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'phone.regex' => 'Phone number must start with +62 and contain only numbers (e.g., +62812345678).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_admin' => $request->has('is_admin'),
        ];

        // Only update password if provided
        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle admin status
     */
    public function toggleAdmin(User $user)
    {
        $oldStatus = $user->is_admin;
        $user->update(['is_admin' => !$user->is_admin]);

        $newStatus = $user->is_admin ? 'Admin' : 'User';
        $action = $user->is_admin ? 'granted' : 'removed';
        
        return redirect()->route('admin.users')->with('success', "Admin privileges {$action} for user: {$user->name}");
    }

    /**
     * Delete all users
     */
    public function deleteAll()
    {
        // Count all users
        $usersToDelete = User::count();
        
        if ($usersToDelete === 0) {
            return redirect()->route('admin.users')->with('error', 'No users to delete.');
        }
        
        // Delete all users
        User::truncate();
        
        return redirect()->route('admin.users')->with('success', "Successfully deleted {$usersToDelete} users.");
    }
}
