<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);
        return view('admin.roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $request->description,
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        $groupedPermissions = $this->groupPermissions($role->permissions);
        return view('admin.roles.show', compact('role', 'groupedPermissions'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
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

        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Group permissions by module.
     */
    private function groupPermissions($permissions)
    {
        $grouped = [];
        $modules = [
            'dashboard' => 'Dashboard',
            'projects' => 'Projects',
            'tenders' => 'Tenders',
            'news' => 'News/Updates',
            'gallery' => 'Gallery',
            'events' => 'Events',
            'downloads' => 'Downloads',
            'sectors' => 'Sectors',
            'team' => 'Team',
            'designations' => 'Designations',
            'leadership' => 'Leadership',
            'users' => 'Users',
            'roles' => 'Roles',
            'settings' => 'Settings',
            'registrations' => 'Registrations',
            'bulk' => 'Bulk Actions',
            'profile' => 'Profile',
        ];

        foreach ($modules as $key => $label) {
            $grouped[$key] = [
                'label' => $label,
                'permissions' => [],
            ];
        }

        foreach ($permissions as $permission) {
            $module = explode('.', $permission->name)[0] ?? 'other';
            
            if (isset($grouped[$module])) {
                $grouped[$module]['permissions'][] = $permission;
            } else {
                if (!isset($grouped['other'])) {
                    $grouped['other'] = ['label' => 'Other', 'permissions' => []];
                }
                $grouped['other']['permissions'][] = $permission;
            }
        }

        return array_filter($grouped, fn($group) => count($group['permissions']) > 0);
    }
}