<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ongoing_project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('implementing_modality');
            $table->decimal('government_contribution', 15, 2);
            $table->decimal('government_return', 15, 2);
            $table->decimal('private_party_return', 15, 2);
            $table->timestamps();
            
            // Add index for better performance
            $table->index('project_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ongoing_project_details');
    }
};