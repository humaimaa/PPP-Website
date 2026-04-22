<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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