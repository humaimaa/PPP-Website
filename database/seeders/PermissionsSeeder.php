<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->command->info('Creating permissions...');

        // ==================== MODULES PERMISSIONS ====================
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

        // Basic CRUD permissions for each module
        foreach ($modules as $module => $label) {
            Permission::firstOrCreate(['name' => "{$module}.view", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.create", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.edit", 'guard_name' => 'web']);
            Permission::firstOrCreate(['name' => "{$module}.delete", 'guard_name' => 'web']);
        }

        // ==================== ADDITIONAL MODULE-SPECIFIC PERMISSIONS ====================
        
        // Users specific permissions
        Permission::firstOrCreate(['name' => 'users.toggle_status', 'guard_name' => 'web']);
        
        // Gallery specific permissions
        Permission::firstOrCreate(['name' => 'gallery.set_thumbnail', 'guard_name' => 'web']);

        // ==================== BULK DELETE PERMISSION ====================
        Permission::firstOrCreate(['name' => 'bulk.delete', 'guard_name' => 'web']);

        $this->command->info('Permissions created: ' . Permission::count());

        // ==================== CREATE ROLES ====================
        $this->command->info('Creating roles...');

        // Get all permissions
        $allPermissions = Permission::all();

        // 1. Super Admin Role - Has ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions($allPermissions);
        $this->command->info('✓ Super Admin role created with ' . $superAdminRole->permissions->count() . ' permissions');

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
        $this->command->info('✓ Admin role created with ' . $adminRole->permissions->count() . ' permissions');

        // 3. Content Manager Role - Can manage content modules only
        $contentManagerRole = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManagerPermissions = Permission::whereIn('name', [
            'projects.view', 'projects.create', 'projects.edit',
            'tenders.view', 'tenders.create', 'tenders.edit',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.set_thumbnail',
            'sectors.view', 'sectors.create', 'sectors.edit',
            'designations.view', 'designations.create', 'designations.edit',
            'downloads.view', 'downloads.create', 'downloads.edit',
            'team.view', 'team.create', 'team.edit',
            'leadership.view', 'leadership.create', 'leadership.edit',
            'users.view', 'users.toggle_status',
        ])->get();
        $contentManagerRole->syncPermissions($contentManagerPermissions);
        $this->command->info('✓ Content Manager role created with ' . $contentManagerRole->permissions->count() . ' permissions');

        // 4. Editor Role - Can view, create, and edit only (no delete, no toggle)
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $editorPermissions = Permission::whereIn('name', [
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
        ])->get();
        $editorRole->syncPermissions($editorPermissions);
        $this->command->info('✓ Editor role created with ' . $editorRole->permissions->count() . ' permissions');

        // 5. Viewer Role - Read-only access for all modules
        $viewerRole = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewerPermissions = Permission::whereIn('name', [
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
        ])->get();
        $viewerRole->syncPermissions($viewerPermissions);
        $this->command->info('✓ Viewer role created with ' . $viewerRole->permissions->count() . ' permissions');

        $this->command->info('==========================================');
        $this->command->info('Total roles created: ' . Role::count());
        $this->command->info('==========================================');
    }
}