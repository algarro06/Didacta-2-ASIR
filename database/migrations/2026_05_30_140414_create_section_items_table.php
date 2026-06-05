<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('section_items', function (Blueprint $table) {
            $table->increments('id_item');
            $table->unsignedInteger('section_id');
            $table->enum('type', ['temario', 'tarea']);
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('section_id')
                  ->references('id_section')
                  ->on('course_sections')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('section_items');
    }
};
