<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Mengisi tabel sub_kriteria dengan rentang nilai konversi (SRS: FR-05)
     * Data mentah mahasiswa akan dikonversi ke skor berdasarkan tabel ini.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak dobel saat re-seed
        SubKriteria::truncate();

        // ── C1: Nilai IPK (Benefit) ───────────────────────────
        // Skala IPK: 0.00 - 4.00
        $c1 = Kriteria::where('kode', 'C1')->first();
        if ($c1) {
            $this->insertSubKriteria($c1->id, [
                ['label' => 'Sangat Baik (3.51 - 4.00)',  'nilai_min' => 3.51, 'nilai_max' => 4.00, 'skor' => 100],
                ['label' => 'Baik (3.01 - 3.50)',         'nilai_min' => 3.01, 'nilai_max' => 3.50, 'skor' => 75],
                ['label' => 'Cukup (2.51 - 3.00)',        'nilai_min' => 2.51, 'nilai_max' => 3.00, 'skor' => 50],
                ['label' => 'Kurang (2.00 - 2.50)',        'nilai_min' => 2.00, 'nilai_max' => 2.50, 'skor' => 25],
            ]);
        }

        // ── C2: Penghasilan Orang Tua (Cost) ─────────────────
        // Semakin kecil penghasilan, semakin layak mendapat beasiswa
        // Nilai dalam Rupiah
        $c2 = Kriteria::where('kode', 'C2')->first();
        if ($c2) {
            $this->insertSubKriteria($c2->id, [
                ['label' => '≤ Rp 500.000',                   'nilai_min' => 0,         'nilai_max' => 500000,    'skor' => 100],
                ['label' => 'Rp 500.001 - Rp 1.500.000',      'nilai_min' => 500001,    'nilai_max' => 1500000,   'skor' => 75],
                ['label' => 'Rp 1.500.001 - Rp 2.500.000',    'nilai_min' => 1500001,   'nilai_max' => 2500000,   'skor' => 50],
                ['label' => 'Rp 2.500.001 - Rp 4.000.000',    'nilai_min' => 2500001,   'nilai_max' => 4000000,   'skor' => 25],
                ['label' => '> Rp 4.000.000',                  'nilai_min' => 4000001,   'nilai_max' => 99999999,  'skor' => 10],
            ]);
        }

        // ── C3: Semester (Benefit) ────────────────────────────
        // Semester aktif mahasiswa (1 - 14)
        $c3 = Kriteria::where('kode', 'C3')->first();
        if ($c3) {
            $this->insertSubKriteria($c3->id, [
                ['label' => 'Semester 7 - 14', 'nilai_min' => 7,  'nilai_max' => 14, 'skor' => 100],
                ['label' => 'Semester 5 - 6',  'nilai_min' => 5,  'nilai_max' => 6,  'skor' => 75],
                ['label' => 'Semester 3 - 4',  'nilai_min' => 3,  'nilai_max' => 4,  'skor' => 50],
                ['label' => 'Semester 1 - 2',  'nilai_min' => 1,  'nilai_max' => 2,  'skor' => 25],
            ]);
        }

        // ── C4: Jumlah Tanggungan Orang Tua (Benefit) ────────
        // Semakin banyak tanggungan, semakin layak
        $c4 = Kriteria::where('kode', 'C4')->first();
        if ($c4) {
            $this->insertSubKriteria($c4->id, [
                ['label' => '≥ 4 tanggungan',    'nilai_min' => 4, 'nilai_max' => 99, 'skor' => 100],
                ['label' => '3 tanggungan',       'nilai_min' => 3, 'nilai_max' => 3,  'skor' => 75],
                ['label' => '2 tanggungan',       'nilai_min' => 2, 'nilai_max' => 2,  'skor' => 50],
                ['label' => '1 tanggungan',       'nilai_min' => 1, 'nilai_max' => 1,  'skor' => 25],
            ]);
        }

        // ── C5: Keikutsertaan Organisasi (Benefit) ────────────
        // Jumlah organisasi yang diikuti
        $c5 = Kriteria::where('kode', 'C5')->first();
        if ($c5) {
            $this->insertSubKriteria($c5->id, [
                ['label' => '≥ 4 organisasi',   'nilai_min' => 4, 'nilai_max' => 99, 'skor' => 100],
                ['label' => '3 organisasi',      'nilai_min' => 3, 'nilai_max' => 3,  'skor' => 75],
                ['label' => '2 organisasi',      'nilai_min' => 2, 'nilai_max' => 2,  'skor' => 50],
                ['label' => '1 organisasi',      'nilai_min' => 1, 'nilai_max' => 1,  'skor' => 25],
                ['label' => 'Tidak ikut (0)',    'nilai_min' => 0, 'nilai_max' => 0,  'skor' => 10],
            ]);
        }
    }

    /**
     * Helper: insert array sub kriteria ke tabel
     */
    private function insertSubKriteria(int $kriteriaId, array $items): void
    {
        foreach ($items as $item) {
            SubKriteria::create([
                'kriteria_id' => $kriteriaId,
                'label'       => $item['label'],
                'nilai_min'   => $item['nilai_min'],
                'nilai_max'   => $item['nilai_max'],
                'skor'        => $item['skor'],
            ]);
        }
    }
}
