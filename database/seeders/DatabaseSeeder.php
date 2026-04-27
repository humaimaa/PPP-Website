<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,  // creates super-admin role first
            AdminUserSeeder::class,             // then creates user and assigns role
        ]);
    }
}