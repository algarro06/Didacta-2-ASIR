<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->increments('id_section');
            $table->unsignedInteger('course_id');
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id_course')
                  ->on('course')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_sections');
    }
};
