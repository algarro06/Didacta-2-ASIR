<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->string('type'); 
            // taller, charla, examen, social

            $table->string('color'); 
            // azul, verde, morado, rojo...

            $table->string('location')->nullable();

            $table->string('instructor')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};