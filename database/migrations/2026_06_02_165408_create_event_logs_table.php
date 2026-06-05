<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();

            // ID del evento relacionado
            $table->unsignedBigInteger('event_id');

            // Tipo de acción (INSERT, UPDATE, DELETE si amplías luego)
            $table->string('action');

            // Fecha de creación del log
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_logs');
    }
};