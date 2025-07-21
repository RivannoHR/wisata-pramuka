@extends('app')

@section('title', 'Edit Profile - Pulau Pramuka')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .form-header {
        background: #f8fafc;
        padding: 25px 30px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a1a1a;
        box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
    }

    .form-control.error {
        border-color: #dc2626;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: #1a1a1a;
        color: white;
    }

    .btn-primary:hover {
        background: #374151;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        text-decoration: none;
        color: #374151;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .password-requirements {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .password-requirements ul {
        margin: 5px 0 0 0;
        padding-left: 20px;
    }

    .password-requirements li {
        margin-bottom: 2px;
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px 15px;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .form-body {
            padding: 20px;
        }
    }
</style>

<div class="profile-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Edit Profile</h1>
        <p>Update your account information and security settings</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            Please fix the errors below and try again.
        </div>
    @endif

    <!-- Profile Information Form -->
    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas fa-user"></i>
                Profile Information
            </h2>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="form-control {{ $errors->has('username') ? 'error' : '' }}" 
                               value="{{ old('username', $user->username) }}" 
                               placeholder="Enter a unique username">
                        <small style="color: #6b7280; font-size: 0.875rem; margin-top: 4px; display: block;">
                            Only letters, numbers, and underscores allowed
                        </small>
                        @error('username')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control {{ $errors->has('name') ? 'error' : '' }}" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control {{ $errors->has('email') ? 'error' : '' }}" 
                           value="{{ old('email', $user->email) }}" 
                           required>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-control {{ $errors->has('phone') ? 'error' : '' }}" 
                               value="{{ old('phone', $user->phone) }}" 
                               placeholder="e.g., +62812345678">
                        @error('phone')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" 
                               id="address" 
                               name="address" 
                               class="form-control {{ $errors->has('address') ? 'error' : '' }}" 
                               value="{{ old('address', $user->address) }}" 
                               placeholder="Your address">
                        @error('address')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Change Form -->
    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas fa-lock"></i>
                Change Password
            </h2>
        </div>
        <div class="form-body">
            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="form-control {{ $errors->has('current_password') ? 'error' : '' }}" 
                           required>
                    @error('current_password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control {{ $errors->has('password') ? 'error' : '' }}" 
                               required>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control" 
                               required>
                    </div>
                </div>

                <div class="password-requirements">
                    <strong>Password Requirements:</strong>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Mix of uppercase and lowercase letters recommended</li>
                        <li>Include numbers and special characters for better security</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-key"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
