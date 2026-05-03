<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::with('subKriteria')->orderBy('kode')->get();
        return view('admin.sub-kriteria.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'label'       => 'nullable|string|max:100',
            'nilai_min'   => 'required|numeric',
            'nilai_max'   => 'required|numeric|gte:nilai_min',
            'skor'        => 'required|numeric|min:0',
        ]);

        SubKriteria::create($request->only(['kriteria_id', 'label', 'nilai_min', 'nilai_max', 'skor']));

        return back()->with('success', 'Sub kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, SubKriteria $subKriterium)
    {
        $request->validate([
            'label'     => 'nullable|string|max:100',
            'nilai_min' => 'required|numeric',
            'nilai_max' => 'required|numeric|gte:nilai_min',
            'skor'      => 'required|numeric|min:0',
        ]);

        $subKriterium->update($request->only(['label', 'nilai_min', 'nilai_max', 'skor']));

        return back()->with('success', 'Sub kriteria berhasil diperbarui.');
    }

    public function destroy(SubKriteria $subKriterium)
    {
        $subKriterium->delete();
        return back()->with('success', 'Sub kriteria berhasil dihapus.');
    }
}
