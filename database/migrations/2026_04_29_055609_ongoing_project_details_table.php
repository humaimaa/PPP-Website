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
            $table->text('implementing_modality');
            $table->text('government_contribution');
            $table->text('government_return');
            $table->text('private_party_return');
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