@extends('app')

@section('content')
<div class="login-container">
    <div class="login-box">
        <h2>What are you waiting for?</h2>
        <p>Dive into a tropical journey now.</p>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-button">Log In</button>
        </form>

        <div class="register-link">
            No account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</div>
@endsection