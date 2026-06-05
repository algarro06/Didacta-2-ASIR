<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id_course')
                  ->on('course')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id_user')
                  ->on('userr')
                  ->onDelete('cascade');

            $table->unique(['course_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_user');
    }
};
