<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $kuota        = PengaturanSistem::get('kuota_beasiswa', 5);
        $namaBeasiswa = PengaturanSistem::get('nama_beasiswa', 'Beasiswa PPA');
        $periodeAktif = PengaturanSistem::get('periode_aktif', date('Y'));

        return view('admin.pengaturan.index', compact('kuota', 'namaBeasiswa', 'periodeAktif'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'kuota_beasiswa' => 'required|integer|min:1',
            'nama_beasiswa'  => 'required|string|max:255',
            'periode_aktif'  => 'required|integer|min:2000|max:2100',
        ]);

        PengaturanSistem::set('kuota_beasiswa', $request->kuota_beasiswa, 'Kuota penerima beasiswa');
        PengaturanSistem::set('nama_beasiswa', $request->nama_beasiswa, 'Nama program beasiswa');
        PengaturanSistem::set('periode_aktif', $request->periode_aktif, 'Tahun/periode seleksi aktif');

        return back()->with('success', 'Pengaturan sistem berhasil disimpan.');
    }
}
