<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('weekday');           // 1 = lundi ... 7 = dimanche
            $table->time('start_time')->default('09:00');
            $table->time('end_time')->default('17:00');
            $table->unsignedSmallInteger('slot_duration')->default(30); // minutes
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['doctor_id', 'weekday']);          // un seul horaire par jour et par médecin
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};