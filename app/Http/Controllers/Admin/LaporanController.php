<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\PengaturanSistem;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');
        $hasil        = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();

        return view('admin.laporan.index', compact('hasil', 'kuota', 'periodeAktif', 'namaBeasiswa'));
    }

    public function cetak()
    {
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');
        $hasil        = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();

        return view('admin.laporan.cetak', compact('hasil', 'kuota', 'periodeAktif', 'namaBeasiswa'));
    }

    public function exportPdf()
    {
        $kuota        = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');
        $hasil        = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('hasil', 'kuota', 'periodeAktif', 'namaBeasiswa'))
                  ->setPaper('a4', 'portrait');

        $filename = 'laporan-seleksi-' . strtolower(str_replace(' ', '-', $namaBeasiswa)) . '-' . $periodeAktif . '.pdf';

        return $pdf->download($filename);
    }
}

