<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Pendaftar;
use App\Models\PengaturanSistem;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk stat cards (SRS: Section 3.1.2.1)
        $stats = [
            'total_pendaftar'  => Pendaftar::count(),
            'terverifikasi'    => Pendaftar::where('status_verifikasi', 'terverifikasi')->count(),
            'pending'          => Pendaftar::where('status_verifikasi', 'pending')->count(),
            'ditolak'          => Pendaftar::where('status_verifikasi', 'ditolak')->count(),
            'kriteria_aktif'   => Kriteria::where('aktif', true)->count(),
            'kuota_beasiswa'   => PengaturanSistem::get('kuota_beasiswa', 5),
        ];

        // Tabel pendaftar terbaru (5 data)
        $pendaftar_terbaru = Pendaftar::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'pendaftar_terbaru'));
    }
}