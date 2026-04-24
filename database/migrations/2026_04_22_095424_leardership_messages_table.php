<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leadership_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->text('message');
            // $table->string('image')->nullable(); // stored path e.g. leadership/filename.jpg
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leadership_messages');
    }
};