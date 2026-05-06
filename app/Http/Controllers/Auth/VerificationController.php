<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('admin.dashboard'))
            : view('admin.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     * This method handles the email verification link click.
     */
    public function verify(Request $request, $id, $hash)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        
        // Verify the hash matches the user's email
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('admin.login')->with('error', 'Invalid verification link.');
        }
        
        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('admin.login')->with('info', 'Email already verified. Please login.');
        }
        
        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        // Redirect to login with success message
        return redirect()->route('admin.login')->with('success', 'Email verified successfully! You can now login.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}