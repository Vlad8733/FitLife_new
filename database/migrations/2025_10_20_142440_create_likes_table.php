<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['post', 'comment']); // fixed
            $table->timestamps();
            $table->boolean('is_like')->default(true);
            $table->unique(['user_id', 'post_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}