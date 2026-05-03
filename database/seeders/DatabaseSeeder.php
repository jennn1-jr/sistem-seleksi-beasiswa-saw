<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,       // Admin & mahasiswa demo
            KriteriaSeeder::class,   // C1-C5 (harus sebelum SubKriteria!)
            SubKriteriaSeeder::class, // Rentang nilai per kriteria
            PengaturanSeeder::class, // Kuota & pengaturan sistem
        ]);
    }
}