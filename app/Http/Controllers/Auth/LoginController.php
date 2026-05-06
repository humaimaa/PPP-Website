<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ADD THIS

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $credentials = $request->only('email', 'password');
    $remember    = $request->boolean('remember');

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // Check if email is verified
    if (!$user->hasVerifiedEmail()) {
        // Try to send verification email again
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            \Log::error('Failed to send verification on login: ' . $e->getMessage());
        }
        
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Please verify your email address before logging in. A verification link has been sent to your email.']);
    }

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Your account has been deactivated. Please contact an administrator.']);
        }

        if ($user->roles()->count() === 0) {
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Your account has no roles assigned.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    return back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => 'These credentials do not match our records.']);
}
    
    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('status', 'You have been successfully logged out.');
    }
}