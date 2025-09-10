<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sleeps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');           // дата сна
            $table->time('start_time');     // время начала
            $table->time('end_time');       // время окончания
            $table->float('duration')->nullable(); // продолжительность в часах
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sleeps');
    }
};
