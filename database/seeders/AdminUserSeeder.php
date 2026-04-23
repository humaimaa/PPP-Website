<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@pppkpk.gov.pk'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('admin123'), // Encrypted password
                'email_verified_at' => now(),
            ]
        );
        
        // Assign Super Admin role
        if (!$superAdmin->hasRole('Super Admin')) {
            $superAdmin->assignRole('Super Admin');
        }

        // Create regular Admin user
        $admin = User::firstOrCreate(
            ['email' => 'manager@pppkpk.gov.pk'],
            [
                'name' => 'Admin Manager',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );
        
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        // Create Content Manager
        $contentManager = User::firstOrCreate(
            ['email' => 'content@pppkpk.gov.pk'],
            [
                'name' => 'Content Manager',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );
        
        if (!$contentManager->hasRole('Content Manager')) {
            $contentManager->assignRole('Content Manager');
        }

        // Create Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@pppkpk.gov.pk'],
            [
                'name' => 'Editor User',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );
        
        if (!$editor->hasRole('Editor')) {
            $editor->assignRole('Editor');
        }

        // Create Viewer
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@pppkpk.gov.pk'],
            [
                'name' => 'Viewer User',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );
        
        if (!$viewer->hasRole('Viewer')) {
            $viewer->assignRole('Viewer');
        }

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin: admin@pppkpk.gov.pk / admin123');
        $this->command->info('Admin: manager@pppkpk.gov.pk / admin123');
        $this->command->info('Content Manager: content@pppkpk.gov.pk / admin123');
        $this->command->info('Editor: editor@pppkpk.gov.pk / admin123');
        $this->command->info('Viewer: viewer@pppkpk.gov.pk / admin123');
    }
}