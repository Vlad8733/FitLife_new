<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Автор поста
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Основной текст/описание поста
            $table->text('content')->nullable();

            // Путь к медиа (фото или видео)
            $table->string('media_path')->nullable();

            // Тип медиа: image или video
            $table->enum('media_type', ['image', 'video'])->nullable();

            // Количество просмотров
            $table->unsignedBigInteger('views')->default(0);

            // Количество лайков (если хочешь, можешь вынести в отдельную таблицу)
            $table->unsignedBigInteger('likes_count')->default(0);

            // Количество комментариев (для оптимизации, необязательно)
            $table->unsignedBigInteger('comments_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
