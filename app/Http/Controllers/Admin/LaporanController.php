<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Pendaftar;
use App\Models\PengaturanSistem;

class LaporanController extends Controller
{
    public function index()
    {
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));
        $hasil        = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();

        return view('admin.laporan.index', compact('hasil', 'kuota', 'periodeAktif'));
    }

    public function cetak()
    {
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));
        $hasil        = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();

        return view('admin.laporan.cetak', compact('hasil', 'kuota', 'periodeAktif'));
    }

    public function exportPdf()
    {
        // Akan diimplementasikan dengan dompdf
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }
}
