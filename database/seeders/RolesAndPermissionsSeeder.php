<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // First, create all permissions and basic roles
        $this->call(PermissionsSeeder::class);

        // Optional: Assign a default role to existing admin user (if exists)
        $this->assignDefaultRolesToUsers();

        $this->command->info('==========================================');
        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('==========================================');
        
        // Display summary
        $this->command->info('Permissions created: ' . Permission::count());
        $this->command->info('Roles created: ' . Role::count());
    }

    /**
     * Assign default roles to existing admin users
     */
    private function assignDefaultRolesToUsers(): void
    {
        // Assign Super Admin role to the first user (if exists)
        $firstUser = User::first();
        if ($firstUser) {
            $superAdminRole = Role::where('name', 'Super Admin')->first();
            if ($superAdminRole && !$firstUser->hasRole('Super Admin')) {
                $firstUser->assignRole('Super Admin');
                $this->command->info("Assigned 'Super Admin' role to user: {$firstUser->email}");
            }
        }
    }
}