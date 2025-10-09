<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OTPVerificationController extends Controller
{
    /**
     * Show OTP verification form
     */
    public function showVerifyForm()
    {
        $user = Auth::user();
        
        if ($user->isFullyVerified()) {
            return redirect()->route('profile.show')->with('success', 'Your email is already verified.');
        }

        return view('verify-email', compact('user'));
    }

    /**
     * Send OTP to user's email
     */
    public function sendOTP(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isFullyVerified()) {
            $message = 'Email is already verified.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return redirect()->route('verify.email')->with('error', $message);
        }

        try {
            $otp = $user->generateEmailOTP();
            
            // Send OTP via email
            Mail::raw("Your OTP verification code is: {$otp}\n\nThis code will expire in 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification OTP - Wisata Pramuka');
            });

            $successMessage = 'OTP sent to your email address.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => $successMessage,
                    'expires_at' => $user->email_otp_expires_at->format('Y-m-d H:i:s')
                ]);
            }
            
            return redirect()->route('verify.email')->with('success', $successMessage);
        } catch (\Exception $e) {
            $errorMessage = 'Failed to send OTP. Please try again.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMessage]);
            }
            return redirect()->route('verify.email')->with('error', $errorMessage);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $user = Auth::user();
        
        if ($user->isFullyVerified()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Email is already verified.']);
            }
            return redirect()->route('verify.email')->with('success', 'Your email is already verified.');
        }

        if ($user->verifyEmailOTP($request->otp)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Email verified successfully!',
                    'redirect' => route('profile.show')
                ]);
            }
            return redirect()->route('profile.show')->with('success', 'Email verified successfully!');
        }

        $errorMessage = 'Invalid OTP. Please try again.';
        if ($user->isOTPExpired()) {
            $errorMessage = 'OTP has expired. Please request a new one.';
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $errorMessage]);
        }
        
        return redirect()->route('verify.email')->with('error', $errorMessage);
    }

    /**
     * Resend OTP
     */
    public function resendOTP(Request $request)
    {
        return $this->sendOTP($request);
    }
}
