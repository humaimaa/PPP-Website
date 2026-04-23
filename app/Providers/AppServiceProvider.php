<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Super Admin Bypass - MUST be here
        Gate::before(function ($user, $ability) {
            if ($user) {
                // Check by role name
                if ($user->hasRole('Super Admin')) {
                    return true;
                }
                
                // Alternative: Check by user ID (if you know the ID)
                // if ($user->id === 1) {
                //     return true;
                // }
            }
            return null;
        });

        // Create storage directories
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