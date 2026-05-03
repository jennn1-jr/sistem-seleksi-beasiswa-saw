<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    public function index()
    {
        $pendaftar = Pendaftar::latest()->get();
        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function create()
    {
        $kriteria = Kriteria::where('aktif', true)->orderBy('kode')->get();
        return view('admin.pendaftar.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'                      => 'required|string|unique:pendaftar,nim',
            'nama'                     => 'required|string|max:100',
            'program_studi'            => 'required|string|max:100',
            'semester'                 => 'required|integer|min:1|max:14',
            'email'                    => 'nullable|email',
            'no_hp'                    => 'nullable|string|max:20',
            'ipk'                      => 'nullable|numeric|min:0|max:4',
            'penghasilan_ortu'         => 'nullable|numeric|min:0',
            'semester_aktif'           => 'nullable|integer|min:1|max:14',
            'jml_tanggungan'           => 'nullable|integer|min:0',
            'keikutsertaan_organisasi' => 'nullable|integer|min:0',
        ]);

        Pendaftar::create($request->all());

        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Data pendaftar berhasil ditambahkan.');
    }

    public function show(Pendaftar $pendaftar)
    {
        $kriteria = Kriteria::where('aktif', true)->orderBy('kode')->get();
        return view('admin.pendaftar.show', compact('pendaftar', 'kriteria'));
    }

    public function edit(Pendaftar $pendaftar)
    {
        $kriteria = Kriteria::where('aktif', true)->orderBy('kode')->get();
        return view('admin.pendaftar.edit', compact('pendaftar', 'kriteria'));
    }

    public function update(Request $request, Pendaftar $pendaftar)
    {
        $request->validate([
            'nama'                     => 'required|string|max:100',
            'program_studi'            => 'required|string|max:100',
            'semester'                 => 'required|integer|min:1|max:14',
            'email'                    => 'nullable|email',
            'no_hp'                    => 'nullable|string|max:20',
            'ipk'                      => 'nullable|numeric|min:0|max:4',
            'penghasilan_ortu'         => 'nullable|numeric|min:0',
            'semester_aktif'           => 'nullable|integer|min:1|max:14',
            'jml_tanggungan'           => 'nullable|integer|min:0',
            'keikutsertaan_organisasi' => 'nullable|integer|min:0',
        ]);

        $pendaftar->update($request->all());

        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    public function destroy(Pendaftar $pendaftar)
    {
        $pendaftar->delete();
        return back()->with('success', 'Data pendaftar berhasil dihapus.');
    }

    // Verifikasi data pendaftar (SRS: FR-07)
    public function verifikasi(Pendaftar $pendaftar)
    {
        $pendaftar->update([
            'status_verifikasi' => 'terverifikasi',
            'verified_by'       => Auth::id(),
            'verified_at'       => now(),
        ]);

        return back()->with('success', 'Data pendaftar berhasil diverifikasi.');
    }

    // Tolak/batalkan verifikasi
    public function tolak(Request $request, Pendaftar $pendaftar)
    {
        $pendaftar->update([
            'status_verifikasi'   => 'ditolak',
            'catatan_verifikasi'  => $request->catatan,
        ]);

        return back()->with('success', 'Data pendaftar ditolak.');
    }
}
