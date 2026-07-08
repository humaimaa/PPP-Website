<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if slug column doesn't exist before adding it
        if (!Schema::hasColumn('sectors', 'slug')) {
            // First, add the slug column without unique constraint
            Schema::table('sectors', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
        }

        // Generate slugs for existing records
        $sectors = \DB::table('sectors')->get();
        foreach ($sectors as $sector) {
            // Only update if slug is empty or null
            if (empty($sector->slug)) {
                $slug = Str::slug($sector->name);
                
                // Check if slug already exists, if so add a number
                $originalSlug = $slug;
                $counter = 1;
                while (\DB::table('sectors')->where('slug', $slug)->where('id', '!=', $sector->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                \DB::table('sectors')
                    ->where('id', $sector->id)
                    ->update(['slug' => $slug]);
            }
        }

        // Now make the slug column unique and not nullable
        Schema::table('sectors', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sectors', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};