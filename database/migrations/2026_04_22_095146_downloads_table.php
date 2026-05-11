<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
           $table->enum('category', ['Legal Framework', 'Prequalified Transaction Advisory', 'Policies ,Regulations and Guidelines', 'Knowledge Hub', 'Pitchbook'])->default('Legal Framework');
            $table->string('document_path');
            $table->date('date');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('downloads');
    }
};