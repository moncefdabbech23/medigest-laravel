<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->string('reason')->nullable();
            $table->string('status', 20)->default('pending'); // pending, confirmed, cancelled, done
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
