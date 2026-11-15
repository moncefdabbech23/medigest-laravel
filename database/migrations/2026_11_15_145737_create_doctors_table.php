<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            // restrictOnDelete : impossible de supprimer une spécialité ou une ville utilisée par un médecin
            $table->foreignId('specialty_id')->constrained()->restrictOnDelete();
            $table->foreignId('city_id')->constrained()->restrictOnDelete();
            $table->string('office_address')->nullable();
            $table->decimal('fee', 8, 2)->default(0);      // tarif en DT : decimal, jamais float
            $table->text('description')->nullable();
            $table->boolean('is_validated')->default(false); // validé par l'admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};