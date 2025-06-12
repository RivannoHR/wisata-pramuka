@extends('app')

@section('title', 'User Profile')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>Manage your account and travel preferences</p>
    </div>

    <div class="profile-content">
        <div class="profile-info">
            <h2>Profile Information</h2>
            <div class="info-item">
                <label>Name:</label>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <div class="info-item">
                <label>Email:</label>
                <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="info-item">
                <label>Member Since:</label>
                <span>{{ Auth::user()->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <div class="profile-actions">
            <h2>Account Actions</h2>
            <div class="action-buttons">
                <a href="#" class="profile-button">Edit Profile</a>
                <a href="#" class="profile-button">Change Password</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="profile-button logout-button">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.profile-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 30px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border-radius: 12px;
}

.profile-header h1 {
    font-size: 32px;
    margin-bottom: 10px;
}

.profile-header p {
    font-size: 16px;
    opacity: 0.9;
}

.profile-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.profile-info, .profile-actions {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.profile-info h2, .profile-actions h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.info-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-weight: 600;
    color: #666;
}

.info-item span {
    color: #333;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.profile-button {
    padding: 12px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    text-align: center;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.profile-button:hover {
    background: #0056b3;
}

.logout-button {
    background: #dc3545;
}

.logout-button:hover {
    background: #c82333;
}

@media (max-width: 768px) {
    .profile-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .profile-header h1 {
        font-size: 24px;
    }
}
</style>
@endsection
