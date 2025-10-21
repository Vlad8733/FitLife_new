<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создаёт таблицу комментариев.
     * Каждый комментарий относится к посту и пользователю.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // ID пользователя, оставившего комментарий
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // ID поста, к которому относится комментарий
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();

            // Текст комментария
            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Удаляет таблицу при откате миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
