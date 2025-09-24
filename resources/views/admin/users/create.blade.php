@extends('admin.dashboard')

@section('content')
<style>
    .create-user-form {
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

    .create-user-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    .create-user-form input,
    .create-user-form select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }

    .create-user-form input:focus,
    .create-user-form select:focus,
    .create-user-form textarea:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .create-user-form textarea {
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

<div class="create-user-form">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
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
                   value="{{ old('email') }}" 
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
                   value="{{ old('username') }}" 
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
                   value="{{ old('phone') }}" 
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
                      maxlength="500">{{ old('address') }}</textarea>
            @if($errors->has('address'))
                <span class="error-message">{{ $errors->first('address') }}</span>
            @endif
            <div class="help-text">Optional: Maximum 500 characters</div>
        </div>

        <div class="form-group">
            <label for="password">Password <span class="required">*</span></label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   placeholder="Enter secure password"
                   required>
            @if($errors->has('password'))
                <span class="error-message">{{ $errors->first('password') }}</span>
            @endif
            <div class="help-text">Password must be at least 8 characters long</div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   placeholder="Confirm password"
                   required>
            <div class="help-text">Re-enter the password to confirm</div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" 
                       id="is_admin" 
                       name="is_admin" 
                       class="checkbox-input"
                       value="1"
                       {{ old('is_admin') ? 'checked' : '' }}>
                <label for="is_admin" class="checkbox-label">
                    Grant administrative privileges
                </label>
            </div>
            <div class="help-text">
                Admin users can access the admin dashboard and manage content
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Create User
            </button>
        </div>
    </form>
</div>

<script>
// Simple password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    
    // You can add a strength indicator here if desired
});

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

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}
</script>
@endsection
