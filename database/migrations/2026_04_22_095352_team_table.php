<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('hierarchy_id')->constrained('hierarchy')->onDelete('cascade');
            $table->string('designation'); // New column for designation title
            $table->string('img');
            $table->string('email');
            $table->string('phone', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team');
    }
};