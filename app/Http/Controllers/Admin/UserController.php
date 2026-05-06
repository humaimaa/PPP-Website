<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users with search functionality.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by verification status
        if ($request->has('verification_status') && $request->verification_status) {
            if ($request->verification_status == 'verified') {
                $query->verified();
            } elseif ($request->verification_status == 'unverified') {
                $query->unverified();
            }
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
            'send_verification' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Handle email verification
        if ($request->has('send_verification') && $request->send_verification == 1) {
            // Send verification email (user must verify)
            event(new Registered($user));
        } else {
            // Auto-verify email (admin created user)
            $user->markEmailAsVerified();
        }

        // Assign roles
        $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
 * Update the specified user.
 */
public function update(Request $request, User $user)
{
    // Simplified validation for editing (only role is required)
    $validated = $request->validate([
        'roles' => ['required', 'array'],
        'roles.*' => ['exists:roles,id'],
    ]);

    // Only update roles, NOT name or email
    $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();
    $user->syncRoles($roleNames);

    return redirect()->route('admin.users.index')
        ->with('success', 'User role updated successfully.');
}

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the last Super Admin
        if ($user->hasRole('Super Admin')) {
            $superAdminCount = User::role('Super Admin')->count();
            if ($superAdminCount <= 1) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Cannot delete the last Super Admin user.');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status.');
        }

        // Prevent deactivating the last Super Admin
        if ($user->hasRole('Super Admin') && $user->is_active) {
            $activeSuperAdminCount = User::role('Super Admin')->where('is_active', true)->count();
            if ($activeSuperAdminCount <= 1) {
                return back()->with('error', 'Cannot deactivate the last active Super Admin user.');
            }
        }

        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "User {$status} successfully.");
    }

    /**
     * Manually verify a user's email
     */
    public function verifyEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return back()->with('success', "{$user->name}'s email has been verified successfully.");
        }
        
        return back()->with('error', "{$user->name}'s email is already verified.");
    }


public function resendVerification(User $user)  // Change from $userId to User $user
{
    
    try {
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->back()->with('error', "{$user->name}'s email is already verified.");
        }

        $user->sendEmailVerificationNotification();

        return redirect()->back()->with('success', "Verification email sent to {$user->email}.");

    } catch (\Exception $e) {
        \Log::error('Verification resend failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to send verification email: ' . $e->getMessage());
    }
}
    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $userIds = $request->user_ids;
        
        // Don't allow deleting yourself
        if (in_array(auth()->id(), $userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Don't allow deleting the last Super Admin
        $superAdminIds = User::role('Super Admin')->pluck('id')->toArray();
        $deletingSuperAdmins = array_intersect($userIds, $superAdminIds);
        
        if (!empty($deletingSuperAdmins)) {
            $remainingSuperAdmins = User::role('Super Admin')
                ->whereNotIn('id', $userIds)
                ->count();
            
            if ($remainingSuperAdmins === 0) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Cannot delete all Super Admin users.');
            }
        }

        $deletedCount = User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "{$deletedCount} user(s) deleted successfully.");
    }

    /**
     * Bulk activate users
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $userIds = $request->user_ids;
        
        // Don't allow activating yourself (though it's fine, just skip)
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });

        $activatedCount = User::whereIn('id', $userIds)->update(['is_active' => true]);

        return redirect()->route('admin.users.index')
            ->with('success', "{$activatedCount} user(s) activated successfully.");
    }

    /**
     * Bulk deactivate users
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $userIds = $request->user_ids;
        
        // Don't allow deactivating yourself
        if (in_array(auth()->id(), $userIds)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        // Don't allow deactivating the last active Super Admin
        $superAdminIds = User::role('Super Admin')->pluck('id')->toArray();
        $deactivatingSuperAdmins = array_intersect($userIds, $superAdminIds);
        
        if (!empty($deactivatingSuperAdmins)) {
            $remainingActiveSuperAdmins = User::role('Super Admin')
                ->where('is_active', true)
                ->whereNotIn('id', $userIds)
                ->count();
            
            if ($remainingActiveSuperAdmins === 0) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Cannot deactivate all active Super Admin users.');
            }
        }

        $deactivatedCount = User::whereIn('id', $userIds)->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', "{$deactivatedCount} user(s) deactivated successfully.");
    }


    
}