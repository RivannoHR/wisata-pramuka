@extends('admin.dashboard')

@section('content')
<style>
    .edit-user-form {
        max-width: 100%;
        height: 100%;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: scroll;
    }

    .user-info-card {
        background: linear-gradient(135deg, #666, #999);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 600;
    }

    .user-details h3 {
        margin: 0 0 5px 0;
        font-size: 20px;
    }

    .user-details p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .edit-user-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .edit-user-form input,
    .edit-user-form select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }

    .edit-user-form input:focus,
    .edit-user-form select:focus,
    .edit-user-form textarea:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .edit-user-form textarea {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }

    .error-message {
        color: #e3342f;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .checkbox-input {
        width: 18px !important;
        height: 18px;
        margin: 0;
    }

    .checkbox-label {
        margin: 0;
        font-weight: 500;
        cursor: pointer;
    }

    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }

    .required {
        color: #e3342f;
    }

    .password-section {
        background: #e9ecef;
        padding: 15px;
        border-radius: 4px;
        margin: 20px 0;
        border-left: 4px solid #666;
    }

    .password-section h4 {
        margin: 0 0 15px 0;
        color: #333;
        font-size: 16px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background: black;
        color: white;
    }

    .btn-primary:hover {
        background: #333;
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
    }

    .btn-danger {
        background: red;
        color: white;
    }

    .btn-danger:hover {
        opacity: 60%;
        color: white;
        text-decoration: none;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-error {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .self-edit-warning {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

@if ($errors->any())
<div class="alert alert-error">
    <strong>Please correct the following errors:</strong>
    <ul style="margin: 8px 0 0 20px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- User Edit Form -->
<div class="user-info-card">
    <div class="user-avatar">
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
    <div class="user-details">
        <h3>{{ $user->name }}</h3>
        <p>Member since {{ $user->created_at->format('F j, Y') }}</p>
        <p>Status: {{ $user->is_admin ? 'Administrator' : 'Regular User' }}</p>
    </div>
</div>

<div class="edit-user-form">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
                   placeholder="Enter user's full name"
                   required>
            @if($errors->has('name'))
                <span class="error-message">{{ $errors->first('name') }}</span>
            @endif
            <div class="help-text">Letters and spaces only</div>
        </div>

        <div class="form-group">
            <label for="email">Email Address <span class="required">*</span></label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}" 
                   placeholder="Enter email address"
                   required>
            @if($errors->has('email'))
                <span class="error-message">{{ $errors->first('email') }}</span>
            @endif
            <div class="help-text">This email will be used for login</div>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" 
                   id="username" 
                   name="username" 
                   value="{{ old('username', $user->username) }}" 
                   placeholder="Enter username (optional)"
                   maxlength="25">
            @if($errors->has('username'))
                <span class="error-message">{{ $errors->first('username') }}</span>
            @endif
            <div class="help-text">Optional: Maximum 25 characters, letters, numbers, and underscores only</div>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" 
                   id="phone" 
                   name="phone" 
                   value="{{ old('phone', $user->phone) }}" 
                   placeholder="+62812345678">
            @if($errors->has('phone'))
                <span class="error-message">{{ $errors->first('phone') }}</span>
            @endif
            <div class="help-text">Optional: Must start with +62 followed by 8-13 digits</div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" 
                      name="address" 
                      rows="3"
                      placeholder="Enter user's address (optional)"
                      maxlength="500">{{ old('address', $user->address) }}</textarea>
            @if($errors->has('address'))
                <span class="error-message">{{ $errors->first('address') }}</span>
            @endif
            <div class="help-text">Optional: Maximum 500 characters</div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" 
                       id="is_admin" 
                       name="is_admin" 
                       class="checkbox-input"
                       value="1"
                       {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                <label for="is_admin" class="checkbox-label">
                    Grant administrative privileges
                </label>
            </div>
            <div class="help-text">
                Admin users can access the admin dashboard and manage content
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" 
                       id="is_verified" 
                       name="is_verified" 
                       class="checkbox-input"
                       value="1"
                       {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
                <label for="is_verified" class="checkbox-label">
                    Mark as verified user
                </label>
            </div>
            <div class="help-text">
                Verified users have confirmed their email address through OTP verification
            </div>
        </div>

        <div class="form-group">
            <label for="email_verified_at">Email Verified Date</label>
            <input type="datetime-local" 
                   id="email_verified_at" 
                   name="email_verified_at" 
                   value="{{ old('email_verified_at', $user->email_verified_at ? $user->email_verified_at->format('Y-m-d\TH:i') : '') }}">
            @if($errors->has('email_verified_at'))
                <span class="error-message">{{ $errors->first('email_verified_at') }}</span>
            @endif
            <div class="help-text">Set when the user's email was verified (leave empty for unverified)</div>
        </div>

        <div class="password-section">
            <h4>Change Password</h4>
            <div class="help-text" style="margin-bottom: 15px;">
                Leave password fields empty if you don't want to change the current password.
            </div>
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter new password (optional)">
                @if($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
                <div class="help-text">Password must be at least 8 characters long</div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       placeholder="Confirm new password">
                <div class="help-text">Re-enter the new password to confirm</div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                Cancel
            </a>
            
            <button type="button" onclick="deleteUser()" class="btn btn-danger">
                Delete User
            </button>
            
            <button type="submit" class="btn btn-primary">
                Update User
            </button>
        </div>
    </form>
</div>

<!-- Delete User Form (hidden) -->
<form id="deleteUserForm" method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteUser() {
    if (confirm(`Are you sure you want to delete user "{{ $user->name }}"? This action cannot be undone.`)) {
        document.getElementById('deleteUserForm').submit();
    }
}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const phoneInput = document.getElementById('phone');

    // Real-time validation for name (alphabetic only) - non-blocking
    nameInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const alphabeticOnly = /^[a-zA-Z\s]*$/;
        
        if (!alphabeticOnly.test(value)) {
            e.target.style.borderColor = '#dc3545';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
            e.target.style.borderColor = '#28a745';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
        }
    });

    // Real-time validation for username (alphanumeric and underscore, max 25 chars) - non-blocking
    usernameInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const validUsername = /^[a-zA-Z0-9_]*$/;
        
        if (value.length > 25) {
            e.target.style.borderColor = '#dc3545';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else if (value && !validUsername.test(value)) {
            e.target.style.borderColor = '#dc3545';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '#ddd';
            e.target.style.boxShadow = value ? '0 0 0 0.2rem rgba(40, 167, 69, 0.25)' : 'none';
        }
    });

    // Real-time validation for phone (+62 format) - non-blocking
    phoneInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const phonePattern = /^\+62[0-9]{8,13}$/;
        
        if (value && !phonePattern.test(value)) {
            e.target.style.borderColor = '#dc3545';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '#ddd';
            e.target.style.boxShadow = value ? '0 0 0 0.2rem rgba(40, 167, 69, 0.25)' : 'none';
        }
    });

    // Auto-format phone number
    phoneInput.addEventListener('focus', function(e) {
        if (!e.target.value) {
            e.target.value = '+62';
        }
    });

    // Reset styles on focus for all inputs
    [nameInput, usernameInput, phoneInput].forEach(input => {
        input.addEventListener('focus', function(e) {
            e.target.style.borderColor = '#007bff';
            e.target.style.boxShadow = '0 0 0 0.2rem rgba(0, 123, 255, 0.25)';
        });
    });
    });

    // Password validation
});

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (password && confirmation && password !== confirmation) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function() {
    const confirmation = document.getElementById('password_confirmation');
    if (confirmation.value) {
        confirmation.dispatchEvent(new Event('input'));
    }
});
</script>
@endsection
