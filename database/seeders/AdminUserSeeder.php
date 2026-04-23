<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Step 1: Make sure the super-admin role exists
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // Step 2: Create the admin user (or find if already exists)
        $user = User::firstOrCreate(
            ['email' => 'admin@pppkpk.gov.pk'],  // find by email
            [
                'name'              => 'Administrator',
                'password'          => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Step 3: Assign the super-admin role
        $user->assignRole('super-admin');

        $this->command->info('✅ Admin user created successfully!');
        $this->command->info('📧 Email:    admin@pppkpk.gov.pk');
        $this->command->info('🔑 Password: admin123');
        $this->command->info('👑 Role:     super-admin');
    }
}