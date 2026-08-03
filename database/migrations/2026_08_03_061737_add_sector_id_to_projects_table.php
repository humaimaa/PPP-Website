<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add sector_id column
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('sector_id')->nullable()->after('sector');
        });

        // Step 2: Migrate data from sector name to sector_id
        $projects = DB::table('projects')->get();
        
        foreach ($projects as $project) {
            if (!empty($project->sector)) {
                // Find sector by name (case-insensitive)
                $sector = DB::table('sectors')
                    ->where('name', 'LIKE', $project->sector)
                    ->first();
                
                if ($sector) {
                    // Update project with sector_id
                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['sector_id' => $sector->id]);
                } else {
                    // If sector doesn't exist, create it automatically
                    $sectorId = DB::table('sectors')->insertGetId([
                        'name' => $project->sector,
                        'slug' => \Illuminate\Support\Str::slug($project->sector),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['sector_id' => $sectorId]);
                }
            }
        }

        // Step 3: Make sector_id NOT NULL after data migration
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('sector_id')->nullable(false)->change();
        });

        // Step 4: Add foreign key constraint
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('sector_id')
                  ->references('id')
                  ->on('sectors')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        // Step 5: Drop the old sector column
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('sector');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back the sector column
        Schema::table('projects', function (Blueprint $table) {
            $table->string('sector')->nullable()->after('sector_id');
        });

        // Step 2: Restore data from sector_id to sector name
        $projects = DB::table('projects')->get();
        
        foreach ($projects as $project) {
            if ($project->sector_id) {
                $sector = DB::table('sectors')
                    ->where('id', $project->sector_id)
                    ->first();
                
                if ($sector) {
                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['sector' => $sector->name]);
                }
            }
        }

        // Step 3: Drop foreign key and sector_id column
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropColumn('sector_id');
        });
    }
};