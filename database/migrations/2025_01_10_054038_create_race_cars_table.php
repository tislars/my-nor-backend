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
        Schema::create('race_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('car_id')->index();
            $table->integer('race_number')->nullable();
            $table->integer('car_model')->nullable();
            $table->string('car_group')->nullable();
            $table->string('team_name')->nullable();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_cars');
    }
};
