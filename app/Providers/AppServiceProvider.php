<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Clear Spatie permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Super Admin bypasses ALL permission checks automatically
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        // Create storage directories if they don't exist
        $directories = [
            'public/events',
            'public/sectors',
            'public/news',
            'public/team',
            'public/tenders',
            'public/documents',
            'public/gallery',
            'public/temp',
        ];

        foreach ($directories as $directory) {
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
        }
    }
}