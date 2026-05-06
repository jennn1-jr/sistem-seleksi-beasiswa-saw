<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Pendaftar;
use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari data pendaftar berdasarkan NIM (username mahasiswa)
        $pendaftar = Pendaftar::where('nim', $user->username)->first();

        // Ambil hasil SAW jika ada
        $hasilSaw = $pendaftar
            ? HasilSaw::where('pendaftar_id', $pendaftar->id)->first()
            : null;

        // Status verifikasi untuk ditampilkan
        $statusVerifikasi = $pendaftar
            ? ucfirst($pendaftar->status_verifikasi)
            : 'Belum Terdaftar';

        // Nama beasiswa dari pengaturan
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');

        return view('mahasiswa.dashboard', compact(
            'pendaftar',
            'hasilSaw',
            'statusVerifikasi',
            'namaBeasiswa'
        ));
    }
}
