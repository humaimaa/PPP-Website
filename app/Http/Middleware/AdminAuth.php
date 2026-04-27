<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Not logged in at all
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Please login to access the admin panel.']);
        }

        // Logged in but not an admin
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'You do not have admin access.']);
        }

        return $next($request);
    }
}