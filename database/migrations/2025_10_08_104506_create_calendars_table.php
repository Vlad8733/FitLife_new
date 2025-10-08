<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    public function up(): void
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('type', [
                'workout', 'rest', 'goal', 'running', 'gym', 'yoga', 'cardio', 'stretching', 'cycling', 'swimming',
                'weightlifting', 'pilates', 'hiking', 'boxing', 'dance', 'crossfit', 'walking', 'meditation',
                'tennis', 'basketball', 'soccer', 'climbing', 'rowing', 'martial_arts', 'recovery'
            ]);
            $table->string('description')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
}