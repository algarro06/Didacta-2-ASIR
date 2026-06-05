<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ============================
        // 📌 TABLA: forum_categories
        // ============================
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // ============================
        // 📌 TABLA: forum_topics
        // ============================
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('forum_categories')
                  ->onDelete('cascade');

            // Tu tabla de usuarios es "userr" y su PK es "id_user"
            $table->foreign('user_id')
                  ->references('id_user')
                  ->on('userr')
                  ->onDelete('cascade');
        });

        // ============================
        // 📌 TABLA: forum_posts
        // ============================
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('topic_id')
                  ->references('id')
                  ->on('forum_topics')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id_user')
                  ->on('userr')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_posts');
        Schema::dropIfExists('forum_topics');
        Schema::dropIfExists('forum_categories');
    }
};
