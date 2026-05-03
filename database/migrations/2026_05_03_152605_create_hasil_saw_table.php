<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel hasil eksekusi SAW - menyimpan snapshot perhitungan (SRS: FR-12)
        Schema::create('hasil_saw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');

            // Nilai konversi / Rating Kecocokan (Matriks X) - SRS: FR-08
            $table->decimal('x_c1', 8, 4)->nullable(); // Skor konversi C1 (IPK)
            $table->decimal('x_c2', 8, 4)->nullable(); // Skor konversi C2 (Penghasilan)
            $table->decimal('x_c3', 8, 4)->nullable(); // Skor konversi C3 (Semester)
            $table->decimal('x_c4', 8, 4)->nullable(); // Skor konversi C4 (Tanggungan)
            $table->decimal('x_c5', 8, 4)->nullable(); // Skor konversi C5 (Organisasi)

            // Nilai normalisasi (Matriks R) - SRS: FR-09
            $table->decimal('r_c1', 8, 6)->nullable(); // Normalisasi C1
            $table->decimal('r_c2', 8, 6)->nullable(); // Normalisasi C2
            $table->decimal('r_c3', 8, 6)->nullable(); // Normalisasi C3
            $table->decimal('r_c4', 8, 6)->nullable(); // Normalisasi C4
            $table->decimal('r_c5', 8, 6)->nullable(); // Normalisasi C5

            // Nilai preferensi akhir Vi - SRS: FR-10
            $table->decimal('nilai_preferensi', 10, 6)->nullable();

            // Perangkingan & hasil - SRS: FR-11, FR-13
            $table->integer('peringkat')->nullable();
            $table->boolean('lolos')->default(false); // apakah masuk kuota beasiswa

            // Metadata eksekusi
            $table->integer('periode')->nullable();   // tahun/periode seleksi
            $table->foreignId('dieksekusi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dieksekusi_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_saw');
    }
};