<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document');
            $table->date('opening_date');
            $table->date('closing_date');
            $table->enum('category', ['General Procurement', 'Transaction Advisory','Private Partner Selection'])->default('General Procurement');
            $table->string('advertisement')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tenders');
    }
};