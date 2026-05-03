<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();        // C1, C2, dst
            $table->string('nama');                       // Nama Kriteria
            $table->enum('tipe', ['benefit', 'cost']);   // Benefit / Cost
            $table->decimal('bobot', 5, 2);              // Bobot (W)
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};