<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::with('permissions')->withCount('users');
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $roles = $query->latest()->paginate(10);
        
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);
        return view('admin.roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        try {
            // Create role
            $role = Role::create([
                'name' => $validated['name'],
                'description' => $request->description,
                'guard_name' => 'web',
            ]);

            // FIX: Convert permission IDs to permission objects
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);

            return redirect()->route('admin.roles.index')
                ->with('success', "Role '{$role->name}' created successfully with " . $permissions->count() . " permissions.");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        $groupedPermissions = $this->groupPermissions($role->permissions);
        return view('admin.roles.show', compact('role', 'groupedPermissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $request->description,
        ]);

        // FIX: Convert permission IDs to permission objects
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete system role: ' . $role->name);
        }

        $role->delete();
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'role_ids' => ['required', 'array'],
            'role_ids.*' => ['exists:roles,id'],
        ]);

        $systemRoles = ['Super Admin', 'Admin'];
        $rolesToDelete = Role::whereIn('id', $request->role_ids)
            ->whereNotIn('name', $systemRoles)
            ->get();

        $deletedCount = 0;
        $deletedRoles = [];
        
        foreach ($rolesToDelete as $role) {
            $deletedRoles[] = $role->name;
            $role->delete();
            $deletedCount++;
        }

        $skippedCount = count($request->role_ids) - $deletedCount;
        
        if ($deletedCount > 0) {
            $message = $deletedCount . " role(s) deleted successfully: " . implode(', ', $deletedRoles);
        } else {
            $message = "No roles were deleted.";
        }
        
        if ($skippedCount > 0) {
            $message .= " " . $skippedCount . " system role(s) were skipped (Super Admin/Admin cannot be deleted).";
        }

        return redirect()->route('admin.roles.index')
            ->with('success', $message);
    }

    private function groupPermissions($permissions)
    {
        $grouped = [];
        
        $modules = [
            'projects' => 'Projects',
            'tenders' => 'Tenders',
            'news' => 'News/Updates',
            'gallery' => 'Gallery',
            'sectors' => 'Sectors',
            'designations' => 'Designations',
            'users' => 'Users',
            'downloads' => 'Downloads',
            'team' => 'Team Members',
            'leadership' => 'Leadership',
            'roles' => 'Roles',
        ];

        // Initialize groups
        foreach ($modules as $key => $label) {
            $grouped[$key] = [
                'label' => $label,
                'permissions' => [],
            ];
        }

        // Group permissions by module
        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);
            $module = $parts[0];
            
            if (isset($grouped[$module])) {
                $grouped[$module]['permissions'][] = $permission;
            }
        }

        // Sort permissions within each group by action order
        foreach ($grouped as &$group) {
            usort($group['permissions'], function($a, $b) {
                $order = [
                    'view' => 1, 
                    'create' => 2, 
                    'edit' => 3, 
                    'delete' => 4, 
                    'toggle_status' => 5,
                    'set_thumbnail' => 6,
                ];
                $actionA = explode('.', $a->name)[1] ?? '';
                $actionB = explode('.', $b->name)[1] ?? '';
                return ($order[$actionA] ?? 99) - ($order[$actionB] ?? 99);
            });
        }

        // Remove empty groups
        return array_filter($grouped, fn($group) => count($group['permissions']) > 0);
    }
}