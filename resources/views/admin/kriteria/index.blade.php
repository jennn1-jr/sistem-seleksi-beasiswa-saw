@extends('layouts.admin')

@section('title', 'Kelola Kriteria')
@section('page-title', 'Kelola Kriteria')
@section('breadcrumb', 'Atur kriteria dan bobot penilaian beasiswa (C1–C5)')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Kriteria</h1>
        <p>Daftar kriteria dan bobot yang digunakan dalam perhitungan SAW.</p>
    </div>
</div>

{{-- ── Info Total Bobot ─────────────────────────────────── --}}
<div class="alert {{ $total_bobot == 15 ? 'alert-success' : 'alert-warning' }}" style="margin-bottom: 20px;">
    @if($total_bobot == 15)
        <i class="fas fa-circle-check"></i>
        <span>Total bobot kriteria: <strong>{{ $total_bobot }}</strong> — Sudah sesuai (W1+W2+W3+W4+W5 = 15).</span>
    @else
        <i class="fas fa-triangle-exclamation"></i>
        <span>Total bobot kriteria saat ini: <strong>{{ $total_bobot }}</strong> — Seharusnya berjumlah 15 sesuai SRS.</span>
    @endif
</div>

{{-- ── Tabel Kriteria ───────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-list-check"></i>
            Daftar Kriteria
            <span class="kriteria-count-badge">
                {{ $kriteria->count() }} kriteria
            </span>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Kode</th>
                    <th>Nama Kriteria</th>
                    <th style="text-align:center; width: 100px;">Tipe</th>
                    <th style="text-align:center; width: 80px;">Bobot (W)</th>
                    <th style="text-align:center; width: 80px;">Status</th>
                    <th style="text-align:center; width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $k)
                <tr>
                    <td>
                        <span style="display: inline-flex; align-items: center; justify-content: center;
                                     width: 36px; height: 36px; border-radius: 8px; font-size: 12px;
                                     font-weight: 700; color: #fff;
                                     background: {{ $k->isBenefit() ? '#7c3aed' : '#ef4444' }};">
                            {{ $k->kode }}
                        </span>
                    </td>
                    <td>
                        <div class="kriteria-nama">{{ $k->nama }}</div>
                    </td>
                    <td style="text-align: center;">
                        @if($k->isBenefit())
                            <span class="badge badge-purple">
                                <i class="fas fa-arrow-trend-up"></i> Benefit
                            </span>
                        @else
                            <span class="badge badge-danger">
                                <i class="fas fa-arrow-trend-down"></i> Cost
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span class="bobot-value">{{ $k->bobot }}</span>
                    </td>
                    <td style="text-align: center;">
                        @if($k->aktif)
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:8px;"></i> Aktif</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:8px;"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.kriteria.edit', $k->id) }}"
                           class="btn btn-secondary btn-sm btn-icon" title="Edit Kriteria">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer: Keterangan Rumus SAW --}}
    <div class="kriteria-footer">
        <div class="kriteria-footer-text">
            <span><i class="fas fa-circle-info" style="color: #7c3aed;"></i>
                <strong>Benefit:</strong> Normalisasi = x<sub>ij</sub> / max(x<sub>ij</sub>)
            </span>
            <span><i class="fas fa-circle-info" style="color: #ef4444;"></i>
                <strong>Cost:</strong> Normalisasi = min(x<sub>ij</sub>) / x<sub>ij</sub>
            </span>
            <span><i class="fas fa-circle-info" style="color: var(--text-muted);"></i>
                <strong>Preferensi:</strong> V<sub>i</sub> = Σ (W<sub>j</sub> × R<sub>ij</sub>)
            </span>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Badge count kriteria */
    .kriteria-count-badge {
        background: #ede9fe; color: #7c3aed;
        font-size: 11px; padding: 2px 8px;
        border-radius: 20px; font-weight: 600;
    }
    [data-theme="dark"] .kriteria-count-badge {
        background: rgba(124,58,237,0.2); color: #c4b5fd;
    }

    /* Nama kriteria */
    .kriteria-nama { font-weight: 500; font-size: 14px; color: var(--text); }

    /* Nilai bobot (W) — ini yang utama */
    .bobot-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
    }

    /* Footer rumus */
    .kriteria-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        background: var(--bg);
        border-radius: 0 0 12px 12px;
    }
    .kriteria-footer-text {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }
    .kriteria-footer-text strong { color: var(--text); }
</style>
@endpush
