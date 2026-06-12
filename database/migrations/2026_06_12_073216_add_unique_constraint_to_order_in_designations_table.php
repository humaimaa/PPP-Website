<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('designations', function (Blueprint $table) {
            // Ensure no existing duplicates before adding unique
            $table->unique('order');
        });
    }

    public function down()
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropUnique(['order']);
        });
    }
};