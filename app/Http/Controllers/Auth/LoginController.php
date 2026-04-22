<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to admin dashboard
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }
    
    /**
     * Handle login request with static credentials
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        
        // Static credentials for development
        $staticEmail = 'admin@pppkpk.gov.pk';
        $staticPassword = 'admin123';
        
        // Check if credentials match static data
        if ($request->email === $staticEmail && $request->password === $staticPassword) {
            // Store admin session
            session([
                'admin_logged_in' => true,
                'admin_email' => $staticEmail,
                'admin_name' => 'Administrator',
                'admin_role' => 'Super Admin',
                'login_time' => now(),
            ]);
            
            // Set remember me if checked
            if ($request->has('remember')) {
                session(['admin_remember' => true]);
            }
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, Administrator!');
        }
        
        // Invalid credentials
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }
    
    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Clear admin session
        session()->forget([
            'admin_logged_in',
            'admin_email',
            'admin_name',
            'admin_role',
            'login_time',
            'admin_remember',
        ]);
        
        // Regenerate session ID for security
        session()->regenerate();
        
        return redirect()->route('admin.login')
            ->with('status', 'You have been successfully logged out.');
    }
}