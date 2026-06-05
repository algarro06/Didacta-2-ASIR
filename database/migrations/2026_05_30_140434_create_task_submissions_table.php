<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->increments('id_submission');
            $table->unsignedInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->string('file_path');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('item_id')
                  ->references('id_item')
                  ->on('section_items')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id_user')
                  ->on('userr')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_submissions');
    }
};