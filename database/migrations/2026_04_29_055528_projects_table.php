<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sector');
            $table->string('implementing_authority');
            $table->string('location')->nullable();
            $table->decimal('cost', 15, 2);
            $table->string('status')->nullable();
            $table->text('overview');
            $table->string('image'); 
            $table->enum('division', ['Bannu', 'Dera Ismail Khan', 'Hazara', 'Kohat', 'Malakand', 'Mardan', 'Peshawar', 'FATA']);
            $table->enum('category', ['Pipeline', 'Ongoing', 'Completed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};