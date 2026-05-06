<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            // Rename old column
            $table->renameColumn('description', 'content');

            // Add missing columns if they don't exist yet
            if (!Schema::hasColumn('news', 'type')) {
                $table->enum('type', ['Update','Event','Announcement','Press Release','Notice','Circular'])
                      ->default('Update')
                      ->after('content');
            }
            if (!Schema::hasColumn('news', 'event_date')) {
                $table->date('event_date')->nullable()->after('type');
            }
            if (!Schema::hasColumn('news', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('event_date');
            }
            if (!Schema::hasColumn('news', 'pdf_path')) {
                $table->string('pdf_path')->nullable()->after('is_featured');
            }

            // Drop old columns no longer needed
            if (Schema::hasColumn('news', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('news', 'img')) {
                $table->dropColumn('img');
            }
        });
    }

    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('content', 'description');

            $table->dropColumn(['type', 'event_date', 'is_featured', 'pdf_path']);

            $table->date('date')->after('description');
            $table->string('img')->nullable()->after('date');
        });
    }
};