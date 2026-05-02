<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->string('label')->nullable();     // Label/keterangan rentang
            $table->decimal('nilai_min', 10, 2)->nullable(); // Nilai minimum rentang
            $table->decimal('nilai_max', 10, 2)->nullable(); // Nilai maksimum rentang
            $table->decimal('skor', 5, 2);           // Skor konversi (misal: 75, 100)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};