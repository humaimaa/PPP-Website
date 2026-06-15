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
            $table->enum('designation', ['Chief Minister', 'Chief Secretary','Additional Chief Secretary Development', 'Secretary P&D', 'Chief PPP']);            
            $table->text('message');
            $table->timestamps();
             $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leadership_messages');
    }
};