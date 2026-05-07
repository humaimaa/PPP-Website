<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('roles');
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id)
            ],
        ]);

        // Check if email is being changed
        $emailChanged = $user->email !== $validated['email'];
        
        if ($emailChanged) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        // If email changed, send new verification email
        if ($emailChanged) {
            event(new Registered($user));
        }

        $message = 'Profile updated successfully.';
        if ($emailChanged) {
            $message .= ' A verification link has been sent to your new email address.';
        }

        return redirect()->route('admin.profile')
            ->with('success', $message);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter and one number.',
            'password.min' => 'The password must be at least 8 characters.',
            'current_password.current_password' => 'The current password is incorrect.',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Password updated successfully. Please use your new password next time you log in.');
    }
}