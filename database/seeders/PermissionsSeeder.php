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

        // ==================== DASHBOARD PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'dashboard.access', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'dashboard.view_stats', 'guard_name' => 'web']);

        // ==================== PROJECTS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'projects.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'projects.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'projects.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'projects.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'projects.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'projects.toggle_status', 'guard_name' => 'web']);

        // ==================== TENDERS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'tenders.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.extend', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'tenders.archive', 'guard_name' => 'web']);

        // ==================== NEWS/UPDATES PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'news.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'news.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'news.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'news.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'news.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'news.toggle_status', 'guard_name' => 'web']);

        // ==================== GALLERY PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'gallery.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.set_thumbnail', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'gallery.publish', 'guard_name' => 'web']);

        // ==================== EVENTS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'events.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'events.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'events.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'events.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'events.manage', 'guard_name' => 'web']);

        // ==================== DOWNLOADS/DOCUMENTS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'downloads.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'downloads.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'downloads.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'downloads.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'downloads.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'downloads.toggle_status', 'guard_name' => 'web']);

        // ==================== SECTORS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'sectors.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'sectors.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'sectors.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'sectors.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'sectors.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'sectors.toggle_status', 'guard_name' => 'web']);

        // ==================== DESIGNATIONS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'designations.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'designations.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'designations.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'designations.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'designations.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'designations.toggle_status', 'guard_name' => 'web']);

        // ==================== TEAM PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'team.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.toggle_status', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'team.reorder', 'guard_name' => 'web']);

        // ==================== LEADERSHIP MESSAGES PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'leadership.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'leadership.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'leadership.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'leadership.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'leadership.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'leadership.toggle_status', 'guard_name' => 'web']);

        // ==================== REGISTRATIONS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'registrations.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'registrations.manage', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'registrations.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'registrations.export', 'guard_name' => 'web']);

        // ==================== SETTINGS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'settings.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'settings.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'settings.manage', 'guard_name' => 'web']);

        // ==================== BULK ACTIONS PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'bulk.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'bulk.publish', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'bulk.unpublish', 'guard_name' => 'web']);

        // ==================== USER MANAGEMENT PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'users.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'users.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'users.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'users.manage', 'guard_name' => 'web']);

        // ==================== ROLE MANAGEMENT PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'roles.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'roles.create', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'roles.edit', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'roles.delete', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'roles.manage', 'guard_name' => 'web']);

        // ==================== PROFILE PERMISSIONS ====================
        Permission::firstOrCreate(['name' => 'profile.view', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'profile.edit', 'guard_name' => 'web']);

        // ==================== CREATE ROLES ====================

        // 1. Super Admin Role - Has ALL permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all());

        // 2. Admin Role - Has most permissions except user/role deletion
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminPermissions = Permission::where('guard_name', 'web')
            ->whereNotIn('name', [
                'users.delete',
                'roles.delete',
                'settings.manage',
            ])
            ->get();
        $adminRole->syncPermissions($adminPermissions);

        // 3. Content Manager Role - Can manage all content but not users/roles/settings
        $contentManagerRole = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManagerPermissions = [
            'dashboard.access',
            'dashboard.view_stats',
            'projects.view', 'projects.create', 'projects.edit', 'projects.manage', 'projects.toggle_status',
            'tenders.view', 'tenders.create', 'tenders.edit', 'tenders.manage', 'tenders.extend', 'tenders.archive',
            'news.view', 'news.create', 'news.edit', 'news.manage', 'news.toggle_status',
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.manage', 'gallery.set_thumbnail', 'gallery.publish',
            'events.view', 'events.create', 'events.edit', 'events.manage',
            'downloads.view', 'downloads.create', 'downloads.edit', 'downloads.manage', 'downloads.toggle_status',
            'sectors.view', 'sectors.create', 'sectors.edit', 'sectors.manage', 'sectors.toggle_status',
            'team.view', 'team.create', 'team.edit', 'team.manage', 'team.toggle_status', 'team.reorder',
            'leadership.view', 'leadership.create', 'leadership.edit', 'leadership.manage', 'leadership.toggle_status',
            'designations.view', 'designations.create', 'designations.edit', 'designations.manage',
            'registrations.view', 'registrations.manage',
            'bulk.publish', 'bulk.unpublish',
            'profile.view', 'profile.edit',
        ];
        $contentManagerRole->syncPermissions(
            Permission::whereIn('name', $contentManagerPermissions)->get()
        );

        // 4. Editor Role - Can create and edit content, but not delete
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);
        $editorPermissions = [
            'dashboard.access',
            'dashboard.view_stats',
            'projects.view', 'projects.create', 'projects.edit',
            'tenders.view', 'tenders.create', 'tenders.edit',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit', 'gallery.set_thumbnail',
            'events.view', 'events.create', 'events.edit',
            'downloads.view', 'downloads.create', 'downloads.edit',
            'sectors.view', 'sectors.create', 'sectors.edit',
            'team.view', 'team.create', 'team.edit',
            'leadership.view', 'leadership.create', 'leadership.edit',
            'designations.view', 'designations.create', 'designations.edit',
            'registrations.view',
            'profile.view', 'profile.edit',
        ];
        $editorRole->syncPermissions(
            Permission::whereIn('name', $editorPermissions)->get()
        );

        // 5. Viewer Role - Read-only access
        $viewerRole = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewerPermissions = [
            'dashboard.access',
            'projects.view',
            'tenders.view',
            'news.view',
            'gallery.view',
            'events.view',
            'downloads.view',
            'sectors.view',
            'team.view',
            'leadership.view',
            'designations.view',
            'registrations.view',
            'profile.view',
        ];
        $viewerRole->syncPermissions(
            Permission::whereIn('name', $viewerPermissions)->get()
        );

        // 6. Tender Manager Role - Specialized role for tender management
        $tenderManagerRole = Role::firstOrCreate(['name' => 'Tender Manager', 'guard_name' => 'web']);
        $tenderManagerPermissions = [
            'dashboard.access',
            'tenders.view', 'tenders.create', 'tenders.edit', 'tenders.delete', 
            'tenders.manage', 'tenders.extend', 'tenders.archive',
            'downloads.view', 'downloads.create', 'downloads.edit',
            'registrations.view',
            'profile.view', 'profile.edit',
        ];
        $tenderManagerRole->syncPermissions(
            Permission::whereIn('name', $tenderManagerPermissions)->get()
        );
    }
}