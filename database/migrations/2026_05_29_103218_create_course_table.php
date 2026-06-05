<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->increments('id_course');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('Activo');
            $table->date('creation_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course');
    }
};
