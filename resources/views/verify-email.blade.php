@extends('app')

@section('title', 'Verify Email - Pulau Pramuka')

@section('content')
<style>
    .verify-container {
        max-width: 500px;
        margin: 80px auto;
        padding: 40px 20px;
    }

    .verify-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 40px;
        text-align: center;
    }

    .verify-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: white;
        font-size: 2rem;
    }

    .verify-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .verify-subtitle {
        color: #6b7280;
        margin-bottom: 32px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 24px;
        text-align: left;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-align: center;
        letter-spacing: 2px;
        font-weight: 600;
    }

    .form-control:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .btn {
        width: 100%;
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        margin-bottom: 16px;
    }

    .btn-primary {
        background: #1a1a1a;
        color: white;
    }

    .btn-primary:hover {
        background: #374151;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .divider {
        margin: 24px 0;
        text-align: center;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e5e7eb;
    }

    .divider span {
        background: white;
        padding: 0 16px;
        color: #6b7280;
        font-size: 0.9rem;
    }

    .back-link {
        text-align: center;
        margin-top: 24px;
    }

    .back-link a {
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .back-link a:hover {
        color: #374151;
        text-decoration: underline;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 0.9rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .otp-input {
        text-transform: uppercase;
        font-family: 'Courier New', monospace;
    }

    #otp-section {
        display: none;
    }

    .verification-status {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        text-align: center;
    }

    .verification-status.verified {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .verification-status.pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fed7aa;
    }
</style>

<div class="verify-container">
    <div class="verify-card">
        <div class="verify-icon">
            <i class="fas fa-shield-check"></i>
        </div>
        
        <h1 class="verify-title">Verify Your Email</h1>
        <p class="verify-subtitle">
            Secure your account by verifying your email address: <strong>{{ auth()->user()->email }}</strong>
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->is_verified)
            <div class="verification-status verified">
                <i class="fas fa-check-circle"></i>
                Your email is already verified!
            </div>
            <a href="{{ route('profile.show') }}" class="btn btn-primary">
                <i class="fas fa-user"></i>
                Back to Profile
            </a>
        @else
            <!-- Send OTP Section -->
            <div id="send-otp-section">
                <p>Click the button below to receive a 6-digit verification code via email.</p>
                
                <form id="send-otp-form" method="POST" action="{{ route('send.otp') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i>
                        Send Verification Code
                    </button>
                </form>
            </div>

            <!-- Verify OTP Section -->
            <div id="otp-section">
                <div class="verification-status pending">
                    <i class="fas fa-clock"></i>
                    A 6-digit verification code has been sent to your email. Please check your inbox.
                </div>

                <form id="verify-otp-form" method="POST" action="{{ route('verify.otp') }}">
                    @csrf
                    <div class="form-group">
                        <label for="otp" class="form-label">Enter Verification Code</label>
                        <input type="text" 
                               id="otp" 
                               name="otp" 
                               class="form-control otp-input" 
                               maxlength="6" 
                               placeholder="000000"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Verify Code
                    </button>
                </form>

                <div class="divider">
                    <span>or</span>
                </div>

                <form id="resend-otp-form" method="POST" action="{{ route('resend.otp') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                        Resend Code
                    </button>
                </form>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('profile.show') }}">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendOtpForm = document.getElementById('send-otp-form');
    const sendOtpSection = document.getElementById('send-otp-section');
    const otpSection = document.getElementById('otp-section');
    const otpInput = document.getElementById('otp');

    // Handle send OTP form submission
    if (sendOtpForm) {
        sendOtpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch('{{ route('send.otp') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    sendOtpSection.style.display = 'none';
                    otpSection.style.display = 'block';
                    otpInput.focus();
                } else {
                    alert(data.message || 'Failed to send OTP. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }

    // Auto-format OTP input
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        otpInput.addEventListener('keyup', function(e) {
            if (this.value.length === 6 && e.key !== 'Backspace') {
                document.getElementById('verify-otp-form').querySelector('button[type="submit"]').focus();
            }
        });
    }

    // Show OTP section if there's an error (meaning OTP was already sent)
    @if(session('error') && !auth()->user()->is_verified)
        sendOtpSection.style.display = 'none';
        otpSection.style.display = 'block';
    @endif
});
</script>
@endsection