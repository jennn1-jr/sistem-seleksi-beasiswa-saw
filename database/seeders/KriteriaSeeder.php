<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Mengisi tabel kriteria dengan data default sesuai SRS (Section 5.5.1)
     * Vektor Bobot: W = [3, 4, 1, 2, 5]
     */
    public function run(): void
    {
        $kriteria = [
            [
                'kode'  => 'C1',
                'nama'  => 'Nilai IPK',
                'tipe'  => 'benefit',   // semakin tinggi semakin baik
                'bobot' => 3,
                'aktif' => true,
            ],
            [
                'kode'  => 'C2',
                'nama'  => 'Penghasilan Orang Tua',
                'tipe'  => 'cost',      // semakin kecil semakin baik
                'bobot' => 4,
                'aktif' => true,
            ],
            [
                'kode'  => 'C3',
                'nama'  => 'Semester',
                'tipe'  => 'benefit',   // semakin tinggi semakin baik
                'bobot' => 1,
                'aktif' => true,
            ],
            [
                'kode'  => 'C4',
                'nama'  => 'Jumlah Tanggungan Orang Tua',
                'tipe'  => 'benefit',   // semakin banyak semakin baik
                'bobot' => 2,
                'aktif' => true,
            ],
            [
                'kode'  => 'C5',
                'nama'  => 'Keikutsertaan Organisasi',
                'tipe'  => 'benefit',   // semakin banyak semakin baik
                'bobot' => 5,
                'aktif' => true,
            ],
        ];

        foreach ($kriteria as $item) {
            Kriteria::updateOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
