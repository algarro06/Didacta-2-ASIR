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
        Schema::create('userr', function (Blueprint $table) {

            $table->bigIncrements('id_user');

            $table->string('name', 50);
            $table->string('surname', 50);
            $table->string('mail', 100)->unique();
            $table->string('password', 255);

            $table->dateTime('registration_date')->nullable();

            $table->string('status', 20)->default('Activo');

            $table->unsignedBigInteger('id_role');

            $table->string('full_name')->nullable();

            // FK a roles
            $table->foreign('id_role')
                ->references('id_role')
                ->on('role')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userr');
    }
};