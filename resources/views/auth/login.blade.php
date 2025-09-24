@extends('app')

@section('content')
<style>
    .error-message {
        color: #e3342f;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: 0.25rem;
        display: block;
    }

    .form-group {
        margin-bottom: 1rem;
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

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .password-toggle {
        position: relative;
    }

    .password-toggle input {
        padding-right: 45px;
    }

    .password-toggle .toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #666;
        font-size: 14px;
    }

    .password-toggle .toggle-btn:hover {
        color: #333;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h2>What are you waiting for?</h2>
        <p>Dive into a tropical journey now.</p>
        
        @if ($errors->any())
        <div class="alert alert-error">
            <strong>Login failed:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="form-group">
                <input type="email" 
                       name="email" 
                       placeholder="Email" 
                       value="{{ old('email') }}"
                       required>
                @if($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
            </div>
            
            <div class="form-group password-toggle">
                <input type="password" 
                       id="password"
                       name="password" 
                       placeholder="Password" 
                       required>
                <button type="button" class="toggle-btn" onclick="togglePassword()">👁️</button>
                @if($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
            </div>
            
            <button type="submit" class="login-button">Log In</button>
        </form>
        
        <div class="register-link">
            No account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleBtn = document.querySelector('.toggle-btn');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleBtn.textContent = '🙈';
    } else {
        passwordField.type = 'password';
        toggleBtn.textContent = '👁️';
    }
}

// Real-time validation feedback
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');

    // Email validation
    emailInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value && !emailPattern.test(value)) {
            e.target.style.borderColor = '#dc3545';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '';
        }
    });

    // Password validation
    passwordInput.addEventListener('input', function(e) {
        const value = e.target.value;
        
        if (value.length > 0 && value.length < 6) {
            e.target.style.borderColor = '#dc3545';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '';
        }
    });
});
</script>
@endsection