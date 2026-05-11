<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Kriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PendaftarController extends Controller
{
    public function index()
    {
        $query = Pendaftar::latest();

        // Filter pencarian (nama atau NIM)
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter status verifikasi
        if (request('status')) {
            $query->where('status_verifikasi', request('status'));
        }

        $pendaftar = $query->paginate(15);

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
            'semester'                 => 'required|numeric|integer|min:1|max:14',
            'email'                    => 'nullable|email',
            'no_hp'                    => 'nullable|string|max:20',
            'password'                 => 'required|string|min:6',
            'ipk'                      => 'nullable|numeric|min:0|max:4',
            'penghasilan_ortu'         => 'nullable|numeric|min:0',
            'semester_aktif'           => 'nullable|numeric|integer|min:1|max:14',
            'jml_tanggungan'           => 'nullable|numeric|integer|min:0',
            'keikutsertaan_organisasi' => 'nullable|numeric|integer|min:0',
        ]);

        $pendaftar = Pendaftar::create($request->except('password'));

        // Auto-buat akun mahasiswa dengan password dari form
        if (!User::where('username', $request->nim)->exists()) {
            User::create([
                'name'     => $request->nama,
                'username' => $request->nim,
                'password' => Hash::make($request->password),
                'role'     => 'mahasiswa',
            ]);
        }

        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Data pendaftar ditambahkan. Login mahasiswa: NIM / password yang telah diset.');
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
            'semester'                 => 'required|numeric|integer|min:1|max:14',
            'email'                    => 'nullable|email',
            'no_hp'                    => 'nullable|string|max:20',
            'password'                 => 'nullable|string|min:6',
            'ipk'                      => 'nullable|numeric|min:0|max:4',
            'penghasilan_ortu'         => 'nullable|numeric|min:0',
            'semester_aktif'           => 'nullable|numeric|integer|min:1|max:14',
            'jml_tanggungan'           => 'nullable|numeric|integer|min:0',
            'keikutsertaan_organisasi' => 'nullable|numeric|integer|min:0',
        ]);

        $pendaftar->update($request->except('password'));

        // Ganti password akun mahasiswa jika diisi
        if ($request->filled('password')) {
            User::where('username', $pendaftar->nim)
                ->where('role', 'mahasiswa')
                ->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Data pendaftar berhasil diperbarui.' . ($request->filled('password') ? ' Password mahasiswa ikut diperbarui.' : ''));
    }

    public function destroy(Pendaftar $pendaftar)
    {
        // Hapus juga akun mahasiswa terkait
        User::where('username', $pendaftar->nim)
            ->where('role', 'mahasiswa')
            ->delete();

        $pendaftar->delete();
        return back()->with('success', 'Data pendaftar dan akun mahasiswa berhasil dihapus.');
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
        $validated = $request->validate([
            'catatan' => 'required|string|max:2000',
        ]);

        $pendaftar->update([
            'status_verifikasi'   => 'ditolak',
            'catatan_verifikasi'  => $validated['catatan'],
        ]);

        return back()->with('success', 'Data pendaftar ditolak.');
    }
}
