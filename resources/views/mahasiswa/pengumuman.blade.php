@extends('layouts.mahasiswa')

@section('title', 'Pengumuman Hasil Seleksi')
@section('page-title', 'Pengumuman')
@section('breadcrumb', 'Hasil seleksi beasiswa ' . $namaBeasiswa)

@push('styles')
<style>
    /* Balok status pendaftaran di pengumuman — adaptif light/dark */
    .status-row-surface {
        background: #f1f5f9;
        border-radius: 8px;
    }
    [data-theme="dark"] .status-row-surface {
        background: #1a1d27;
    }
    .status-row-surface .status-label {
        color: #374151;
    }
    [data-theme="dark"] .status-row-surface .status-label {
        color: #64748b;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pengumuman Hasil Seleksi</h1>
        <p>Hasil seleksi <strong>{{ $namaBeasiswa }}</strong> menggunakan metode SAW.</p>
    </div>
</div>

{{-- ── Belum Ada Data Pendaftar ───────────────────────── --}}
@if(!$pendaftar)
<div class="card">
    <div class="card-body" style="padding: 60px; text-align: center;">
        <i class="fas fa-inbox" style="font-size: 48px; color: #374151; display: block; margin-bottom: 16px; opacity: 0.4;"></i>
        <p style="font-size: 15px; font-weight: 500; color: #94a3b8; margin-bottom: 6px;">Data pendaftaran belum ditemukan</p>
        <p style="font-size: 13px; color: #64748b;">NIM Anda belum terdaftar dalam sistem. Silakan hubungi admin kemahasiswaan.</p>
    </div>
</div>

{{-- ── Belum Ada Hasil SAW ─────────────────────────────── --}}
@elseif(!$hasil)
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">

    {{-- Status card --}}
    <div class="card" style="border: 1px solid #1f2430;">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-hourglass-half" style="color:#fbbf24;"></i> Status Pendaftaran</div>
        </div>
        <div class="card-body">
            <div style="text-align: center; padding: 20px 0;">
                <div style="font-size: 40px; margin-bottom: 12px;">⏳</div>
                <p style="font-size: 15px; font-weight: 600; color: #fbbf24; margin-bottom: 6px;">Menunggu Proses SAW</p>
                <p style="font-size: 13px; color: #64748b;">Data Anda sudah terdaftar. Hasil seleksi akan muncul setelah admin menjalankan perhitungan SAW.</p>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 16px;">
                <div class="status-row-surface" style="display:flex; justify-content:space-between; padding:10px 12px;">
                    <span class="status-label" style="font-size:12px;">Verifikasi Data</span>
                    @if($pendaftar->status_verifikasi === 'terverifikasi')
                        <span class="badge badge-success"><i class="fas fa-check"></i> Terverifikasi</span>
                    @elseif($pendaftar->status_verifikasi === 'pending')
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu</span>
                    @else
                        <span class="badge badge-danger"><i class="fas fa-xmark"></i> Ditolak</span>
                    @endif
                </div>
                <div class="status-row-surface" style="display:flex; justify-content:space-between; padding:10px 12px;">
                    <span class="status-label" style="font-size:12px;">Kelengkapan Nilai</span>
                    @if($pendaftar->nilaiLengkap())
                        <span class="badge badge-success"><i class="fas fa-check"></i> C1-C5 Lengkap</span>
                    @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Belum Lengkap</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Info Kriteria --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-list-check"></i> Kriteria Penilaian</div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kriteria</th>
                        <th style="text-align:center;">Tipe</th>
                        <th style="text-align:center;">Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriteria as $k)
                    <tr>
                        <td>
                            <span style="display:inline-flex; align-items:center; justify-content:center;
                                         width:28px; height:28px; border-radius:6px; font-size:10px;
                                         font-weight:700; color:#fff;
                                         background: {{ $k->isBenefit() ? 'rgba(109,40,217,0.5)' : '#7f1d1d' }};">
                                {{ $k->kode }}
                            </span>
                        </td>
                        <td style="font-size:12.5px;">{{ $k->nama }}</td>
                        <td style="text-align:center;">
                            @if($k->isBenefit())
                                <span class="badge badge-purple" style="font-size:10px;">Benefit</span>
                            @else
                                <span class="badge badge-danger" style="font-size:10px;">Cost</span>
                            @endif
                        </td>
                        <td style="text-align:center; font-weight:700; color:#a78bfa;">{{ $k->bobot }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── Ada Hasil SAW ───────────────────────────────────── --}}
@else

    {{-- Banner Hasil --}}
    @if($hasil->lolos)
    <div style="background: linear-gradient(135deg, #064e3b, #065f46);
                border: 1px solid #059669; border-radius: 14px;
                padding: 28px; text-align: center; margin-bottom: 24px;">
        <div style="font-size: 56px; margin-bottom: 12px;">🎉</div>
        <h2 style="font-size: 22px; font-weight: 800; color: #6ee7b7; margin-bottom: 6px;">
            Selamat! Anda Lolos Seleksi Beasiswa
        </h2>
        <p style="font-size: 14px; color: #a7f3d0;">
            {{ $namaBeasiswa }} — Peringkat ke-<strong style="font-size:18px;">{{ $hasil->peringkat }}</strong>
            dari {{ $kuota }} penerima
        </p>
    </div>
    @else
    <div style="background: #1c1917; border: 1px solid #44403c;
                border-radius: 14px; padding: 28px; text-align: center; margin-bottom: 24px;">
        <div style="font-size: 48px; margin-bottom: 12px; opacity: 0.6;">😔</div>
        <h2 style="font-size: 20px; font-weight: 700; color: #94a3b8; margin-bottom: 6px;">
            Maaf, Anda Belum Lolos Seleksi
        </h2>
        <p style="font-size: 13px; color: #64748b;">
            Peringkat Anda: <strong>#{{ $hasil->peringkat }}</strong> &mdash;
            Kuota yang tersedia: {{ $kuota }} mahasiswa.
        </p>
    </div>
    @endif

    {{-- Stat Cards --}}
    <div class="stat-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon {{ $hasil->lolos ? 'green' : 'yellow' }}">
                <i class="fas fa-ranking-star"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">#{{ $hasil->peringkat }}</div>
                <div class="stat-label">Peringkat SAW</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="font-size:18px;">{{ number_format($hasil->nilai_preferensi, 4) }}</div>
                <div class="stat-label">Nilai Preferensi (Vi)</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $kuota }}</div>
                <div class="stat-label">Kuota Penerima</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon {{ $hasil->lolos ? 'green' : 'yellow' }}">
                <i class="fas fa-{{ $hasil->lolos ? 'trophy' : 'circle-xmark' }}"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="font-size:16px;">
                    {{ $hasil->lolos ? 'Lolos ✓' : 'Tdk Lolos' }}
                </div>
                <div class="stat-label">Status Beasiswa</div>
            </div>
        </div>
    </div>

    {{-- Detail Nilai Kriteria --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-table"></i> Detail Nilai & Normalisasi
            </div>
            <span style="font-size:11px; color:#64748b;">
                Dihitung: {{ $hasil->dieksekusi_at?->format('d M Y') }}
            </span>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th style="text-align:center;">Tipe</th>
                        <th style="text-align:center;">Bobot (W)</th>
                        <th style="text-align:center;">Nilai R (Normalisasi)</th>
                        <th style="text-align:center;">W × R</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalVi = 0; @endphp
                    @foreach($kriteria as $k)
                    @php
                        $rCol = 'r_' . strtolower($k->kode);
                        $r    = $hasil->$rCol ?? 0;
                        $wr   = $k->bobot * $r;
                        $totalVi += $wr;
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="display:inline-flex; align-items:center; justify-content:center;
                                             width:28px; height:28px; border-radius:6px; font-size:10px;
                                             font-weight:700; color:#fff;
                                             background: {{ $k->isBenefit() ? 'rgba(109,40,217,0.5)' : '#7f1d1d' }};">
                                    {{ $k->kode }}
                                </span>
                                <span style="font-size:13px;">{{ $k->nama }}</span>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            @if($k->isBenefit())
                                <span class="badge badge-purple" style="font-size:10px;">Benefit</span>
                            @else
                                <span class="badge badge-danger" style="font-size:10px;">Cost</span>
                            @endif
                        </td>
                        <td style="text-align:center; font-weight:700; color:#a78bfa;">{{ $k->bobot }}</td>
                        <td style="text-align:center; font-family:monospace; color:#cbd5e1;">
                            {{ number_format($r, 4) }}
                        </td>
                        <td style="text-align:center; font-weight:600; color:#e2e8f0;">
                            {{ number_format($wr, 4) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: rgba(109,40,217,0.1); border-top: 2px solid #4c1d95;">
                        <td colspan="4" style="text-align:right; font-size:13px; font-weight:700;
                                               color:#a78bfa; padding: 12px 14px;">
                            Nilai Preferensi (Vi) =
                        </td>
                        <td style="text-align:center; font-size:18px; font-weight:800; color:#a78bfa; padding: 12px 14px;">
                            {{ number_format($hasil->nilai_preferensi, 4) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endif

@endsection
