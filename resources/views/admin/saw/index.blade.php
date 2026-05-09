@extends('layouts.admin')

@section('title', 'Eksekusi SAW')
@section('page-title', 'Eksekusi SAW')
@section('breadcrumb', 'Perhitungan Simple Additive Weighting untuk seleksi beasiswa')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Eksekusi SAW</h1>
        <p>Jalankan perhitungan <strong>Simple Additive Weighting</strong> untuk menentukan peringkat penerima beasiswa.</p>
    </div>
    @if($sudah_hitung)
        <a href="{{ route('admin.saw.hasil') }}" class="btn btn-primary">
            <i class="fas fa-trophy"></i> Lihat Hasil Peringkat
        </a>
    @endif
</div>

{{-- ── Stat Cards ───────────────────────────────────────── --}}
<div class="stat-grid" style="margin-bottom: 24px;">

    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $total_terverifikasi }}</div>
            <div class="stat-label">Pendaftar Terverifikasi</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $siap_hitung }}</div>
            <div class="stat-label">Siap Dihitung (nilai lengkap)</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-list-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $kriteria->count() }}</div>
            <div class="stat-label">Kriteria Aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-award"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $kuota }}</div>
            <div class="stat-label">Kuota Penerima Beasiswa</div>
        </div>
    </div>

</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">

    {{-- ── Kolom Kiri: Panel Eksekusi ─────────────────────── --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Card Eksekusi --}}
        <div class="card saw-exec-card {{ $siap_hitung > 0 ? 'card-ready' : 'card-empty' }}">
            <div class="card-header saw-exec-header {{ $siap_hitung > 0 ? 'header-ready' : 'header-empty' }}">
                <div class="card-title">
                    <i class="fas fa-calculator" style="color: #7c3aed;"></i>
                    Jalankan Perhitungan SAW
                </div>
            </div>
            <div class="card-body">

                @if($siap_hitung === 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>Tidak ada pendaftar yang siap dihitung. Pastikan sudah ada pendaftar <strong>terverifikasi</strong> dengan <strong>nilai C1-C5 lengkap</strong>.</span>
                    </div>
                @else
                    <div class="alert alert-info" style="margin-bottom: 20px;">
                        <i class="fas fa-circle-info"></i>
                        <span><strong>{{ $siap_hitung }}</strong> pendaftar siap diproses. Klik tombol di bawah untuk menjalankan perhitungan SAW.</span>
                    </div>

                    @if($sudah_hitung)
                        <div class="alert alert-warning" style="margin-bottom: 20px;">
                            <i class="fas fa-rotate"></i>
                            <span>Perhitungan sebelumnya akan <strong>diganti</strong> dengan hasil yang baru.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.saw.hitung') }}"
                          onsubmit="return konfirmasiHitung()">
                        @csrf
                        <button type="submit" class="btn btn-primary" id="btnHitung"
                                style="width: 100%; padding: 12px; font-size: 14px; font-weight: 600;">
                            <i class="fas fa-calculator"></i>
                            {{ $sudah_hitung ? 'Hitung Ulang SAW' : 'Jalankan Perhitungan SAW' }}
                        </button>
                    </form>
                @endif

            </div>
        </div>

        {{-- Card Tahapan Algoritma SAW --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-diagram-project"></i> Tahapan Algoritma SAW
                </div>
            </div>
            <div class="card-body">
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-num">1</div>
                        <div class="step-text">
                            <div class="step-title">Konversi Nilai Mentah (Matriks X)</div>
                            <div class="step-desc">Data mentah (IPK, penghasilan, dll) diubah ke skor berdasarkan tabel sub kriteria.</div>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <div class="step-text">
                            <div class="step-title">Normalisasi Matriks (Matriks R)</div>
                            <div class="step-desc">
                                Benefit: R = x<sub>ij</sub> / max(x<sub>ij</sub>) &nbsp;|&nbsp;
                                Cost: R = min(x<sub>ij</sub>) / x<sub>ij</sub>
                            </div>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <div class="step-text">
                            <div class="step-title">Nilai Preferensi (Vi)</div>
                            <div class="step-desc">V<sub>i</sub> = Σ (W<sub>j</sub> × R<sub>ij</sub>) — penjumlahan bobot × normalisasi.</div>
                        </div>
                    </div>
                    <div class="step-item" style="margin-bottom: 0;">
                        <div class="step-num">4</div>
                        <div class="step-text">
                            <div class="step-title">Perangkingan & Keputusan</div>
                            <div class="step-desc">Urutkan Vi dari tertinggi. {{ $kuota }} teratas dinyatakan <strong>lolos</strong> beasiswa.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Kolom Kanan: Tabel Kriteria Aktif ──────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list-check"></i> Kriteria yang Digunakan
            </div>
            <span class="text-muted-label">
                Total bobot: <strong>{{ $kriteria->sum('bobot') }}</strong>
            </span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;">Kode</th>
                        <th>Nama Kriteria</th>
                        <th style="text-align:center;">Tipe</th>
                        <th style="text-align:center;">Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriteria as $k)
                    <tr>
                        <td>
                            <span style="display:inline-flex; align-items:center; justify-content:center;
                                         width:32px; height:32px; border-radius:8px; font-size:11px;
                                         font-weight:700; color:#fff;
                                         background: {{ $k->isBenefit() ? '#7c3aed' : '#ef4444' }};">
                                {{ $k->kode }}
                            </span>
                        </td>
                        <td class="td-kriteria-nama">{{ $k->nama }}</td>
                        <td style="text-align:center;">
                            @if($k->isBenefit())
                                <span class="badge badge-purple" style="font-size:10px;">Benefit</span>
                            @else
                                <span class="badge badge-danger" style="font-size:10px;">Cost</span>
                            @endif
                        </td>
                        <td class="td-bobot">
                            {{ $k->bobot }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Peringatan jika pendaftar belum lengkap --}}
        @if($total_terverifikasi > $siap_hitung)
            <div class="warn-bar">
                <div class="warn-bar-text">
                    <i class="fas fa-triangle-exclamation"></i>
                    <strong>{{ $total_terverifikasi - $siap_hitung }}</strong> pendaftar terverifikasi memiliki nilai tidak lengkap dan tidak akan dihitung.
                    <a href="{{ route('admin.pendaftar.index') }}?status=terverifikasi"
                       class="warn-link">Cek di sini →</a>
                </div>
            </div>
        @endif
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Step list */
    .step-list { display: flex; flex-direction: column; gap: 16px; }
    .step-item { display: flex; align-items: flex-start; gap: 12px; }
    .step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #5b21b6);
        color: #fff; font-size: 13px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }
    .step-title { font-size: 13.5px; font-weight: 600; color: var(--text); margin-bottom: 3px; }
    .step-desc  { font-size: 12px; color: var(--text-muted); line-height: 1.5; }

    /* SAW card exec */
    .card-ready { border: 2px solid #c4b5fd; }
    .card-empty { border: 2px solid var(--border); }
    .saw-exec-header.header-ready { background: #faf5ff; }
    .saw-exec-header.header-empty { background: var(--bg); }
    [data-theme="dark"] .saw-exec-header.header-ready { background: rgba(124,58,237,0.12); }
    [data-theme="dark"] .saw-exec-header.header-empty { background: var(--surface); }
    [data-theme="dark"] .card-ready { border-color: rgba(124,58,237,0.5); }

    /* Teks label "Total bobot" */
    .text-muted-label { font-size: 12px; color: var(--text-muted); }

    /* Kolom nama & bobot kriteria */
    .td-kriteria-nama { font-size: 13.5px; font-weight: 500; color: var(--text); }
    .td-bobot { text-align: center; font-size: 18px; font-weight: 800; color: var(--text); }

    /* Warning bar bawah tabel */
    .warn-bar { padding: 14px 20px; border-top: 1px solid var(--border); background: #fffbeb; }
    .warn-bar-text { font-size: 12px; color: #92400e; }
    .warn-link { color: #7c3aed; font-weight: 600; }
    [data-theme="dark"] .warn-bar { background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.25); }
    [data-theme="dark"] .warn-bar-text { color: #fcd34d; }
</style>
@endpush

@push('scripts')
<script>
    function konfirmasiHitung() {
        const setuju = confirm(
            'Jalankan perhitungan SAW sekarang?\n\n' +
            'Hasil perhitungan sebelumnya (jika ada) akan digantikan.\n\n' +
            'Klik OK untuk melanjutkan.'
        );
        if (setuju) {
            const btn = document.getElementById('btnHitung');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghitung...';
        }
        return setuju;
    }
</script>
@endpush
