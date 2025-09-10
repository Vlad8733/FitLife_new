<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // steps, calories, sleep, weight
            $table->decimal('target_value', 10, 2); 
            $table->decimal('current_value', 10, 2)->default(0); 
            $table->date('end_date')->nullable(); // <- nullable, чтобы не было ошибок вставки
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
