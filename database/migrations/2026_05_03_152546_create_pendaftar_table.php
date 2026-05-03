<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->string('program_studi');
            $table->integer('semester');
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            // Nilai mentah per kriteria (SRS: FR-06)
            $table->decimal('ipk', 4, 2)->nullable();          // C1: IPK (Benefit)
            $table->decimal('penghasilan_ortu', 15, 2)->nullable(); // C2: Penghasilan Orang Tua (Cost)
            $table->integer('semester_aktif')->nullable();     // C3: Semester (Benefit) - duplikat field semester jika berbeda
            $table->integer('jml_tanggungan')->nullable();     // C4: Jml. Tanggungan Ortu (Benefit)
            $table->integer('keikutsertaan_organisasi')->nullable(); // C5: Keikutsertaan Organisasi (Benefit, jumlah)
            // Status verifikasi (SRS: FR-07)
            $table->enum('status_verifikasi', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};