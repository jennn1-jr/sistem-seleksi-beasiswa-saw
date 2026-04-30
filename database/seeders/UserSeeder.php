<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin default (SRS: FR-01) ────────────────────
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Administrator',
                'username' => 'admin',
                'email'    => 'admin@kalku.ac.id',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // ── Demo mahasiswa (SRS: FR-01) ───────────────────
        User::updateOrCreate(
            ['username' => '12345'],
            [
                'name'           => 'Ahmad Rahman',
                'username'       => '12345',
                'nim'            => '12345',
                'email'          => 'ahmad@student.ac.id',
                'password'       => Hash::make('student123'),
                'role'           => 'mahasiswa',
                'program_studi'  => 'Teknik Informatika',
            ]
        );
    }
}