@extends('admin.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-tables.css') }}">
<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #666, #999);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-details h4 {
        margin: 0 0 4px 0;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .user-details p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-admin {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .status-user {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .btn-small {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 11px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-edit {
        background-color: #28a745;
        color: white;
    }

    .btn-edit:hover {
        background-color: #218838;
        text-decoration: none;
        color: white;
    }

    .btn-delete {
        background-color: red;
        color: white;
    }

    .btn-delete:hover {
        opacity: 80%;
    }

    .btn-current-user {
        background-color: #6c757d;
        color: white;
        cursor: default;
        font-size: 10px;
    }

    .no-users {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-users i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #ddd;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
</style>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<!-- Filter Section -->
<div class="filter-container">
    <form method="GET" action="{{ route('admin.users') }}" class="filter-form">
        <div class="filter-group">
            <input type="text" 
                   name="search" 
                   class="search-input" 
                   placeholder="Search users (name, email, username)..." 
                   value="{{ request('search') }}">
        </div>
        
        <div class="filter-group">
            <select name="filter_admin" class="filter-select">
                <option value="">All Users</option>
                <option value="1" {{ request('filter_admin') === '1' ? 'selected' : '' }}>Admins Only</option>
                <option value="0" {{ request('filter_admin') === '0' ? 'selected' : '' }}>Regular Users Only</option>
            </select>
        </div>
        
        <button type="submit" class="filter-button">
            Filter
        </button>
    </form>
</div>

<!-- Users Table -->
<div class="table-container">
    @if($users->count() > 0)
    <table>
                <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Admin</th>
                <th>Joined</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <h4>{{ $user->name }}</h4>
                        </div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->username ?: '-' }}</td>
                <td>{{ $user->phone ?: '-' }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn-small {{ $user->is_admin ? 'btn-edit' : 'btn-delete' }}"
                                onclick="return confirm('Are you sure you want to {{ $user->is_admin ? 'remove admin access from' : 'grant admin access to' }} this user?')"
                                title="Click to change admin status">
                            {{ $user->is_admin ? 'Yes' : 'No' }}
                        </button>
                    </form>
                    @else
                    <span class="btn-small btn-current-user">
                        {{ $user->is_admin ? 'Yes' : 'No' }} (You)
                    </span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="action-buttons">
                        <form action="{{ route('admin.users.edit', $user) }}" method="GET" style="display: inline;">
                            <button type="submit" class="btn-small btn-edit">Edit</button>
                        </form>
                        
                        <form action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete user &quot;{{ addslashes($user->name) }}&quot;? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-users">
        <h3>No users found</h3>
        <p>No users match your current filters.</p>
    </div>
    @endif
</div>

<!-- Operation Container -->
<div class="operation-container">
    <form action="{{ route('admin.users.delete-all') }}" 
          method="POST" 
          onsubmit="return confirm('Are you absolutely sure you want to delete all users? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button">
            Delete All Users
        </button>
    </form>
    <form action="{{ route('admin.users.create') }}" method="GET">
        <button type="submit" class="create-button">
            Add User
        </button>
    </form>
</div>

<!-- Delete User Form (hidden) -->
<form id="deleteUserForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection
