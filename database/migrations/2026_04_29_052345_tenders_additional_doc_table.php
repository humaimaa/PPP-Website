<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tender_additional_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->onDelete('cascade');
            $table->string('title');
            $table->date('publish_date');
            $table->string('document');
            $table->timestamps();
            
            // Optional: Add index for better performance
            $table->index('tender_id');
        });
    }



    public function down()
    {
        Schema::dropIfExists('tender_additional_docs');
    }
};