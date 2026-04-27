<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leadership_messages', function (Blueprint $table) {
            $table->string('image')->nullable()->after('designation');
        });
    }

    public function down()
    {
        Schema::table('leadership_messages', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};