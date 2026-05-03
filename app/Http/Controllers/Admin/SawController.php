<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Pendaftar;
use App\Models\PengaturanSistem;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SawController extends Controller
{
    public function index()
    {
        $total_terverifikasi = Pendaftar::where('status_verifikasi', 'terverifikasi')->count();
        $siap_hitung = Pendaftar::where('status_verifikasi', 'terverifikasi')
            ->whereNotNull('ipk')
            ->whereNotNull('penghasilan_ortu')
            ->whereNotNull('semester_aktif')
            ->whereNotNull('jml_tanggungan')
            ->whereNotNull('keikutsertaan_organisasi')
            ->count();

        $kriteria    = Kriteria::where('aktif', true)->orderBy('kode')->get();
        $sudah_hitung = HasilSaw::count() > 0;
        $kuota       = PengaturanSistem::get('kuota_beasiswa', 5);

        return view('admin.saw.index', compact(
            'total_terverifikasi', 'siap_hitung', 'kriteria', 'sudah_hitung', 'kuota'
        ));
    }

    public function hitung(Request $request)
    {
        // Ambil semua pendaftar terverifikasi dengan nilai lengkap
        $pendaftar_list = Pendaftar::where('status_verifikasi', 'terverifikasi')
            ->whereNotNull('ipk')->whereNotNull('penghasilan_ortu')
            ->whereNotNull('semester_aktif')->whereNotNull('jml_tanggungan')
            ->whereNotNull('keikutsertaan_organisasi')
            ->get();

        if ($pendaftar_list->isEmpty()) {
            return back()->with('error', 'Tidak ada pendaftar terverifikasi dengan nilai lengkap.');
        }

        $kriteria = Kriteria::where('aktif', true)->orderBy('kode')->get();

        // ── Step 1: Konversi nilai mentah ke skor (Matriks X) ─
        $matriks_x = [];
        foreach ($pendaftar_list as $p) {
            $matriks_x[$p->id] = [
                'C1' => $this->konversi($p->id, 'C1', $p->ipk),
                'C2' => $this->konversi($p->id, 'C2', $p->penghasilan_ortu),
                'C3' => $this->konversi($p->id, 'C3', $p->semester_aktif),
                'C4' => $this->konversi($p->id, 'C4', $p->jml_tanggungan),
                'C5' => $this->konversi($p->id, 'C5', $p->keikutsertaan_organisasi),
            ];
        }

        // ── Step 2: Normalisasi Matriks (R) per SRS FR-09 ─────
        // Hitung max/min per kriteria
        $max = []; $min = [];
        foreach (['C1','C2','C3','C4','C5'] as $c) {
            $values = array_column(array_map(fn($row) => [$c => $row[$c]], $matriks_x), $c);
            $max[$c] = max($values);
            $min[$c] = min($values);
        }

        $kriteriaMap = $kriteria->keyBy('kode');
        $matriks_r = [];
        foreach ($matriks_x as $pid => $row) {
            foreach (['C1','C2','C3','C4','C5'] as $c) {
                $tipe = $kriteriaMap[$c]?->tipe ?? 'benefit';
                if ($tipe === 'benefit') {
                    $matriks_r[$pid][$c] = $max[$c] > 0 ? $row[$c] / $max[$c] : 0;
                } else {
                    // Cost: min / xij
                    $matriks_r[$pid][$c] = $row[$c] > 0 ? $min[$c] / $row[$c] : 0;
                }
            }
        }

        // ── Step 3: Hitung Nilai Preferensi Vi (SRS: FR-10) ───
        $hasil = [];
        foreach ($pendaftar_list as $p) {
            $vi = 0;
            foreach (['C1','C2','C3','C4','C5'] as $c) {
                $bobot = $kriteriaMap[$c]?->bobot ?? 0;
                $vi   += $bobot * ($matriks_r[$p->id][$c] ?? 0);
            }
            $hasil[$p->id] = $vi;
        }

        // ── Step 4: Perangkingan (SRS: FR-11) ─────────────────
        arsort($hasil);
        $kuota   = (int) PengaturanSistem::get('kuota_beasiswa', 5);
        $peringkat = 1;

        // Hapus hasil lama
        HasilSaw::query()->delete();

        foreach ($hasil as $pid => $vi) {
            $row = $matriks_x[$pid];
            $r   = $matriks_r[$pid];
            HasilSaw::create([
                'pendaftar_id'      => $pid,
                'x_c1' => $row['C1'], 'x_c2' => $row['C2'], 'x_c3' => $row['C3'],
                'x_c4' => $row['C4'], 'x_c5' => $row['C5'],
                'r_c1' => $r['C1'],   'r_c2' => $r['C2'],   'r_c3' => $r['C3'],
                'r_c4' => $r['C4'],   'r_c5' => $r['C5'],
                'nilai_preferensi'  => $vi,
                'peringkat'         => $peringkat,
                'lolos'             => $peringkat <= $kuota,
                'periode'           => (int) PengaturanSistem::get('periode_aktif', date('Y')),
                'dieksekusi_oleh'   => Auth::id(),
                'dieksekusi_at'     => now(),
            ]);
            $peringkat++;
        }

        return redirect()->route('admin.saw.hasil')
            ->with('success', 'Perhitungan SAW berhasil dieksekusi. ' . count($hasil) . ' pendaftar diproses.');
    }

    public function hasil()
    {
        $hasil   = HasilSaw::with('pendaftar')->orderBy('peringkat')->get();
        $kriteria = Kriteria::where('aktif', true)->orderBy('kode')->get();
        $kuota   = (int) PengaturanSistem::get('kuota_beasiswa', 5);

        return view('admin.saw.hasil', compact('hasil', 'kriteria', 'kuota'));
    }

    // Helper: konversi nilai mentah ke skor sub kriteria
    private function konversi(int $pendaftarId, string $kodeKriteria, float $nilaiMentah): float
    {
        $kriteria = Kriteria::where('kode', $kodeKriteria)->first();
        if (!$kriteria) return 0;

        $sub = SubKriteria::where('kriteria_id', $kriteria->id)
            ->where('nilai_min', '<=', $nilaiMentah)
            ->where('nilai_max', '>=', $nilaiMentah)
            ->first();

        return $sub ? (float) $sub->skor : 0;
    }
}
