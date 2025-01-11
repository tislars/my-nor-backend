<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('race_cuts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_car_id')->constrained()->onDelete('cascade');
            $table->integer('lap_number')->nullable();
            $table->integer('penalty_value')->default(0);
            $table->integer('cleared_in_lap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_cuts');
    }
};
