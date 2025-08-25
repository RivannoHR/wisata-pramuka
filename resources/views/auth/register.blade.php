@extends('app')

@section('content')
<div class="login-container">
    <div class="login-box">
        <h2>What are you waiting for?</h2>
        <p>Start your tropical journey now.</p>
        
        <form method="POST" action="{{ route('register') }}" class="login-form">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
            
            <button type="submit" class="login-button">Register</button>
        </form>
        
        <div class="register-link">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
</div>
@endsection

