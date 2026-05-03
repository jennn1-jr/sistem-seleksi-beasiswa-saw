<?php

namespace Database\Seeders;

use App\Models\PengaturanSistem;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Mengisi tabel pengaturan_sistem dengan nilai default (SRS: Section 3.1.2.3)
     * Admin dapat mengubah nilai ini kapan saja melalui menu Pengaturan Sistem.
     */
    public function run(): void
    {
        $pengaturan = [
            [
                'kunci'      => 'kuota_beasiswa',
                'nilai'      => '5',
                'keterangan' => 'Jumlah maksimal mahasiswa yang lolos/diterima beasiswa',
            ],
            [
                'kunci'      => 'nama_beasiswa',
                'nilai'      => 'Beasiswa PPA (Peningkatan Prestasi Akademik)',
                'keterangan' => 'Nama program beasiswa yang sedang diseleksi',
            ],
            [
                'kunci'      => 'periode_aktif',
                'nilai'      => date('Y'),
                'keterangan' => 'Tahun/periode seleksi beasiswa yang sedang berjalan',
            ],
        ];

        foreach ($pengaturan as $item) {
            PengaturanSistem::updateOrCreate(
                ['kunci' => $item['kunci']],
                $item
            );
        }
    }
}
