<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Goal::class)->constrained()->cascadeOnDelete();
            $table->decimal('value', 10, 2);
            $table->integer('change');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goal_logs');
    }
};
