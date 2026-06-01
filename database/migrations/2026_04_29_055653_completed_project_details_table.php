<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('completed_project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->text('scope');
            $table->text('cost_financing_mix');
            $table->text('project_timeline');
            $table->text('expected_financial_benefits_to_government');
            $table->timestamps();
            
            // Add index for better performance
            $table->index('project_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('completed_project_details');
    }
};