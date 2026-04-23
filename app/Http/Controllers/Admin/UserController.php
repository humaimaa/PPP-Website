<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
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
            'is_active' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Assign roles to user
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('admin.users.show', compact('user'));
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active'),
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Sync roles
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the last Super Admin
        if ($user->hasRole('Super Admin')) {
            $superAdminCount = User::role('Super Admin')->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Cannot delete the last Super Admin user.');
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
            return back()->with('error', 'You cannot deactivate your own account.');
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
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:users,id'],
        ]);

        // Don't allow deleting yourself
        if (in_array(auth()->id(), $request->ids)) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Don't allow deleting the last Super Admin
        $superAdminIds = User::role('Super Admin')->pluck('id')->toArray();
        $deletingSuperAdmins = array_intersect($request->ids, $superAdminIds);
        
        if (!empty($deletingSuperAdmins)) {
            $remainingSuperAdmins = User::role('Super Admin')
                ->whereNotIn('id', $request->ids)
                ->count();
            
            if ($remainingSuperAdmins === 0) {
                return back()->with('error', 'Cannot delete all Super Admin users.');
            }
        }

        User::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' users deleted successfully.');
    }

    /**
     * Bulk activate users
     */
    public function bulkActivate(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:users,id'],
        ]);

        User::whereIn('id', $request->ids)->update(['is_active' => true]);

        return back()->with('success', count($request->ids) . ' users activated successfully.');
    }

    /**
     * Bulk deactivate users
     */
    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:users,id'],
        ]);

        // Don't allow deactivating yourself
        if (in_array(auth()->id(), $request->ids)) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        // Don't allow deactivating the last active Super Admin
        $superAdminIds = User::role('Super Admin')->pluck('id')->toArray();
        $deactivatingSuperAdmins = array_intersect($request->ids, $superAdminIds);
        
        if (!empty($deactivatingSuperAdmins)) {
            $remainingActiveSuperAdmins = User::role('Super Admin')
                ->where('is_active', true)
                ->whereNotIn('id', $request->ids)
                ->count();
            
            if ($remainingActiveSuperAdmins === 0) {
                return back()->with('error', 'Cannot deactivate all active Super Admin users.');
            }
        }

        User::whereIn('id', $request->ids)->update(['is_active' => false]);

        return back()->with('success', count($request->ids) . ' users deactivated successfully.');
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        $users = User::with('roles')->get();
        
        $filename = 'users_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $handle = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($handle, [
            'ID',
            'Name',
            'Email',
            'Roles',
            'Status',
            'Email Verified',
            'Created At',
            'Last Updated'
        ]);
        
        // Add data rows
        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->roles->pluck('name')->implode(', '),
                $user->is_active ? 'Active' : 'Inactive',
                $user->email_verified_at ? 'Verified' : 'Not Verified',
                $user->created_at->format('Y-m-d H:i:s'),
                $user->updated_at->format('Y-m-d H:i:s'),
            ]);
        }
        
        fclose($handle);
        
        return response()->stream(
            function() use ($users) {
                // Output is already sent via fputcsv
            },
            200,
            $headers
        );
    }
}