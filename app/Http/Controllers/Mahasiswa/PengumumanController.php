<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Pendaftar;
use App\Models\PengaturanSistem;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        $pendaftar    = Pendaftar::where('nim', $user->username)->first();
        $hasil        = null;
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');
        $kriteria     = Kriteria::where('aktif', true)->orderBy('kode')->get();

        if ($pendaftar) {
            $hasil = HasilSaw::where('pendaftar_id', $pendaftar->id)->first();
        }

        return view('mahasiswa.pengumuman', compact('pendaftar', 'hasil', 'kuota', 'kriteria', 'namaBeasiswa'));
    }
}
