<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // ==================== MODULES PERMISSIONS ====================
        $modules = [
            'projects',
            'tenders',
            'news',
            'gallery',
            'sectors',
            'designations',
            'users',
            'downloads',
            'team',
            'leadership',
            'roles',
        ];

        // Basic CRUD permissions for each module
        foreach ($modules as $module) {
            Permission::firstOrCreate(['name' => "{$module}.view", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.create", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.edit", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.delete", 'guard_name' => 'web']);
        }

        // ==================== ADDITIONAL MODULE-SPECIFIC PERMISSIONS ====================
        
        // Users specific permissions (toggle_status only for users)
        Permission::firstOrCreate(['name' => 'users.toggle_status', 'guard_name' => 'web']);
        
        // Gallery specific permissions (set_thumbnail for gallery)
        Permission::firstOrCreate(['name' => 'gallery.set_thumbnail', 'guard_name' => 'web']);
        
        // Tenders specific permissions (extend for tenders)
        Permission::firstOrCreate(['name' => 'tenders.extend', 'guard_name' => 'web']);

        // ==================== BULK DELETE PERMISSION ====================
        Permission::firstOrCreate(['name' => 'bulk.delete', 'guard_name' => 'web']);

        // ==================== CREATE ROLES ====================

        // 1. Super Admin Role - Has ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all());

        // 2. Admin Role - Has all permissions except role management and user delete
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminPermissions = Permission::where('guard_name', 'web')
            ->whereNotIn('name', [
                'roles.view',
                'roles.create',
                'roles.edit',
                'roles.delete',
                'users.delete',
                'bulk.delete',
            ])
            ->get();
        $adminRole->syncPermissions($adminPermissions);

        // 3. Content Manager Role - Can manage content modules only
        $contentManagerRole = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManagerPermissions = [
            'projects.view', 'projects.create', 'projects.edit',
            'tenders.view', 'tenders.create', 'tenders.edit', 'tenders.extend',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.set_thumbnail',
            'sectors.view', 'sectors.create', 'sectors.edit',
            'designations.view', 'designations.create', 'designations.edit',
            'downloads.view', 'downloads.create', 'downloads.edit',
            'team.view', 'team.create', 'team.edit',
            'leadership.view', 'leadership.create', 'leadership.edit',
            'users.view', 'users.toggle_status',
        ];
        $contentManagerRole->syncPermissions(
            Permission::whereIn('name', $contentManagerPermissions)->get()
        );

        // 4. Editor Role - Can view, create, and edit only (no delete, no toggle)
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $editorPermissions = [
            'projects.view', 'projects.create', 'projects.edit',
            'tenders.view', 'tenders.create', 'tenders.edit',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit',
            'sectors.view', 'sectors.create', 'sectors.edit',
            'designations.view', 'designations.create', 'designations.edit',
            'downloads.view', 'downloads.create', 'downloads.edit',
            'team.view', 'team.create', 'team.edit',
            'leadership.view', 'leadership.create', 'leadership.edit',
            'users.view',
        ];
        $editorRole->syncPermissions(
            Permission::whereIn('name', $editorPermissions)->get()
        );

        // 5. Viewer Role - Read-only access for all modules
        $viewerRole = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewerPermissions = [
            'projects.view',
            'tenders.view',
            'news.view',
            'gallery.view',
            'sectors.view',
            'designations.view',
            'downloads.view',
            'team.view',
            'leadership.view',
            'users.view',
        ];
        $viewerRole->syncPermissions(
            Permission::whereIn('name', $viewerPermissions)->get()
        );
    }
}