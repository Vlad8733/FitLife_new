<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealLogsTable extends Migration
{
    public function up()
    {
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('meal'); // Breakfast, Lunch, Dinner, Snack
            $table->string('food');
            $table->integer('quantity'); // граммы/мл
            $table->integer('calories'); // подсчитанные калории
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal_logs');
    }
}
