<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria      = Kriteria::orderBy('kode')->get();
        $total_bobot   = $kriteria->sum('bobot');
        return view('admin.kriteria.index', compact('kriteria', 'total_bobot'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'  => 'required|string|max:10|unique:kriteria,kode',
            'nama'  => 'required|string|max:100',
            'tipe'  => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0',
        ]);

        $kriteria = Kriteria::create($request->only(['kode', 'nama', 'tipe', 'bobot']));

        LogAktivitas::catat(
            'Menambah kriteria ' . $kriteria->kode . ' (' . $kriteria->nama . ')',
            'kriteria'
        );

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriterium)
    {
        return view('admin.kriteria.edit', ['kriteria' => $kriterium]);
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'tipe'  => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0',
            'aktif' => 'boolean',
        ]);

        $kriterium->update([
            'nama'  => $request->nama,
            'tipe'  => $request->tipe,
            'bobot' => $request->bobot,
            'aktif' => $request->boolean('aktif'),
        ]);

        LogAktivitas::catat(
            'Mengubah data kriteria ' . $kriterium->kode . ' (' . $kriterium->nama . ')',
            'kriteria'
        );

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();
        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}
