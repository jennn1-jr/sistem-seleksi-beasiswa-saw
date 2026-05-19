@extends('layouts.mahasiswa')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name)

@push('styles')
<style>
    /* Theme helpers for dashboard mahasiswa */
    .text-on-dark { color: #f1f5f9 !important; }
    .text-on-dark-soft { color: #64748b !important; }
    .muted-adaptive { color: var(--text-sub) !important; }
    .title-adaptive { color: var(--text-head); }

    /* Balok status pendaftaran — adaptif light/dark */
    .row-dark-surface {
        background: #f1f5f9;
        border-radius: 10px;
    }
    [data-theme="dark"] .row-dark-surface {
        background: #1a1d27;
    }
    .row-dark-surface .status-label {
        color: #374151;
    }
    [data-theme="dark"] .row-dark-surface .status-label {
        color: #cbd5e1;
    }

    .criteria-row {
        border-bottom: 1px solid var(--row-border) !important;
    }
    .empty-state {
        color: var(--text-sub) !important;
    }
    .flow-step-pending {
        background: var(--table-head) !important;
        border-color: var(--border) !important;
        color: var(--text-sub) !important;
    }
    .flow-step-done {
        background: rgba(109, 40, 217, 0.3) !important;
        border-color: #7c3aed !important;
        color: #a78bfa !important;
    }
</style>
@endpush

@section('content')

{{-- ── Greeting Banner ─────────────────────────────────── --}}
<div style="background: linear-gradient(135deg, #1e1b4b 0%, #16181f 60%);
            border: 1px solid #2d2060;
            border-radius: 14px;
            padding: 24px 28px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;">
    <div>
        <div style="font-size: 11px; font-weight: 600; color: #7c3aed;
                    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">
            <i class="fas fa-graduation-cap"></i> Portal Beasiswa
        </div>
        <h2 class="text-on-dark" style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">
            Halo, {{ Auth::user()->name }}! 👋
        </h2>
        <p class="text-on-dark-soft" style="font-size: 13px;">
            NIM: <strong style="color: #a78bfa;">{{ Auth::user()->username }}</strong>
            &nbsp;|&nbsp; Sistem Seleksi Beasiswa — Metode SAW
        </p>
    </div>
    <div style="text-align: center; background: rgba(124,58,237,0.15);
                border: 1px solid rgba(124,58,237,0.3);
                border-radius: 12px; padding: 14px 20px;">
        <div style="font-size: 28px; font-weight: 800; color: #a78bfa;">{{ $namaBeasiswa }}</div>
        <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Program Beasiswa Aktif</div>
    </div>
</div>

{{-- ── Stat Cards ───────────────────────────────────────── --}}
<div class="stat-grid" style="margin-bottom: 24px;">

    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-user-check"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $statusVerifikasi }}</div>
            <div class="stat-label">Status Pendaftaran</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon {{ $hasilSaw ? 'green' : 'yellow' }}">
            <i class="fas fa-calculator"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value" style="font-size: {{ $hasilSaw ? '16px' : '24px' }};">
                {{ $hasilSaw ? number_format($hasilSaw->nilai_preferensi, 4) : '-' }}
            </div>
            <div class="stat-label">Nilai SAW (Vi)</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-ranking-star"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $hasilSaw ? '#' . $hasilSaw->peringkat : '-' }}</div>
            <div class="stat-label">Peringkat</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon {{ $hasilSaw && $hasilSaw->lolos ? 'green' : 'yellow' }}">
            <i class="fas fa-award"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value" style="font-size: 16px;">
                @if(!$hasilSaw)
                    Belum
                @elseif($hasilSaw->lolos)
                    Lolos ✓
                @else
                    Tdk Lolos
                @endif
            </div>
            <div class="stat-label">Status Beasiswa</div>
        </div>
    </div>

</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- ── Kolom Kiri: Status Detail ───────────────────── --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Status Pendaftaran --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-clipboard-check"></i> Status Pendaftaran Anda
                </div>
            </div>
            <div class="card-body">
                @if(!$pendaftar)
                    <div class="alert alert-warning">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>Data pendaftaran Anda belum terdaftar. Hubungi admin untuk input data.</span>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">

                        {{-- Status verifikasi --}}
                        <div class="row-dark-surface" style="display: flex; justify-content: space-between; align-items: center; padding: 12px;">
                            <span class="status-label" style="font-size: 13px;">Verifikasi Data</span>
                            @if($pendaftar->status_verifikasi === 'terverifikasi')
                                <span class="badge badge-success"><i class="fas fa-circle-check"></i> Terverifikasi</span>
                            @elseif($pendaftar->status_verifikasi === 'pending')
                                <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-circle-xmark"></i> Ditolak</span>
                            @endif
                        </div>

                        {{-- Nilai lengkap --}}
                        <div class="row-dark-surface" style="display: flex; justify-content: space-between; align-items: center; padding: 12px;">
                            <span class="status-label" style="font-size: 13px;">Kelengkapan Nilai</span>
                            @if($pendaftar->nilaiLengkap())
                                <span class="badge badge-success"><i class="fas fa-check"></i> Lengkap (C1-C5)</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Belum Lengkap</span>
                            @endif
                        </div>

                        {{-- Hasil SAW --}}
                        <div class="row-dark-surface" style="display: flex; justify-content: space-between; align-items: center; padding: 12px;">
                            <span class="status-label" style="font-size: 13px;">Hasil Seleksi SAW</span>
                            @if($hasilSaw)
                                @if($hasilSaw->lolos)
                                    <span class="badge badge-success"><i class="fas fa-trophy"></i> Lolos Beasiswa</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-xmark"></i> Tidak Lolos</span>
                                @endif
                            @else
                                <span class="badge badge-warning"><i class="fas fa-hourglass-half"></i> Belum Diproses</span>
                            @endif
                        </div>

                    </div>

                    {{-- Catatan verifikasi jika ditolak --}}
                    @if($pendaftar->status_verifikasi === 'ditolak' && $pendaftar->catatan_verifikasi)
                        <div class="alert alert-danger" style="margin-top: 14px;">
                            <i class="fas fa-circle-xmark"></i>
                            <span><strong>Catatan Admin:</strong> {{ $pendaftar->catatan_verifikasi }}</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Info Proses --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-circle-info" style="color:#60a5fa;"></i> Alur Seleksi
                </div>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @php $step = 0;
                        if($pendaftar) $step = 1;
                        if($pendaftar && $pendaftar->nilaiLengkap()) $step = 2;
                        if($pendaftar && $pendaftar->isVerified()) $step = 3;
                        if($hasilSaw) $step = 4;
                    @endphp

                    @foreach([
                        ['icon'=>'fa-user-plus',      'label'=>'Data didaftarkan admin'],
                        ['icon'=>'fa-list-check',     'label'=>'Nilai kriteria C1–C5 dilengkapi'],
                        ['icon'=>'fa-shield-check',   'label'=>'Data diverifikasi admin'],
                        ['icon'=>'fa-calculator',     'label'=>'Perhitungan SAW dieksekusi'],
                    ] as $i => $s)
                    <div style="display:flex; align-items:center; gap:10px; opacity: {{ $step > $i ? '1' : '0.4' }};">
                        <div class="{{ $step > $i ? 'flow-step-done' : 'flow-step-pending' }}" style="width:28px; height:28px; border-radius:50%; flex-shrink:0;
                                    border: 2px solid;
                                    display:flex; align-items:center; justify-content:center;
                                    font-size:11px;">
                            @if($step > $i)
                                <i class="fas fa-check"></i>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <span class="{{ $step > $i ? 'title-adaptive' : 'muted-adaptive' }}" style="font-size:13px;">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ── Kolom Kanan: Data Nilai Kriteria ────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-calculator"></i> Data Nilai Kriteria Anda
            </div>
        </div>
        <div class="card-body">
            @if(!$pendaftar)
                <div class="empty-state" style="text-align:center; padding: 40px 0;">
                    <i class="fas fa-inbox" style="font-size:36px; display:block; margin-bottom:12px; opacity:0.4;"></i>
                    <p style="font-size:13px;">Data belum terdaftar</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column;">

                    @php
                        $kriteria_data = [
                            ['kode'=>'C1', 'nama'=>'Nilai IPK',               'nilai'=> $pendaftar->ipk !== null ? number_format($pendaftar->ipk, 2) : null,                 'tipe'=>'Benefit', 'bobot'=>3],
                            ['kode'=>'C2', 'nama'=>'Penghasilan Orang Tua',   'nilai'=> $pendaftar->penghasilan_ortu !== null ? 'Rp '.number_format($pendaftar->penghasilan_ortu,0,',','.') : null, 'tipe'=>'Cost',    'bobot'=>4],
                            ['kode'=>'C3', 'nama'=>'Semester Aktif',           'nilai'=> $pendaftar->semester_aktif !== null ? 'Semester '.$pendaftar->semester_aktif : null, 'tipe'=>'Benefit', 'bobot'=>1],
                            ['kode'=>'C4', 'nama'=>'Jumlah Tanggungan',       'nilai'=> $pendaftar->jml_tanggungan !== null ? $pendaftar->jml_tanggungan.' orang' : null,    'tipe'=>'Benefit', 'bobot'=>2],
                            ['kode'=>'C5', 'nama'=>'Keikutsertaan Organisasi','nilai'=> $pendaftar->keikutsertaan_organisasi !== null ? $pendaftar->keikutsertaan_organisasi.' org' : null, 'tipe'=>'Benefit', 'bobot'=>5],
                        ];
                    @endphp

                    @foreach($kriteria_data as $k)
                    <div class="criteria-row" style="display:flex; align-items:center; justify-content:space-between;
                                padding: 13px 0; gap:12px;
                                {{ $loop->last ? 'border-bottom:none;' : '' }}">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="display:inline-flex; align-items:center; justify-content:center;
                                         width:30px; height:30px; border-radius:7px; font-size:10px;
                                         font-weight:700; color:#fff;
                                         background: {{ $k['tipe'] === 'Cost' ? '#7f1d1d' : 'rgba(109,40,217,0.5)' }};">
                                {{ $k['kode'] }}
                            </span>
                            <div>
                                <div class="title-adaptive" style="font-size:13px; font-weight:500;">{{ $k['nama'] }}</div>
                                <div style="font-size:10px; color: {{ $k['tipe'] === 'Cost' ? '#f87171' : '#6ee7b7' }}; font-weight:600;">
                                    {{ $k['tipe'] }} · Bobot {{ $k['bobot'] }}
                                </div>
                            </div>
                        </div>
                        <div style="font-size:13.5px; font-weight:700;
                                    color: {{ $k['nilai'] ? '#a78bfa' : '#4b5563' }};">
                            {{ $k['nilai'] ?? '—' }}
                        </div>
                    </div>
                    @endforeach

                    {{-- Hasil SAW jika ada --}}
                    @if($hasilSaw)
                    <div style="margin-top:16px; padding:14px; background:rgba(109,40,217,0.1);
                                border:1px solid rgba(109,40,217,0.3); border-radius:10px; text-align:center;">
                        <div style="font-size:11px; color:#7c3aed; font-weight:600; text-transform:uppercase; margin-bottom:8px;">
                            <i class="fas fa-trophy"></i> Hasil Perhitungan SAW
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div>
                                <div style="font-size:22px; font-weight:800; color:#a78bfa;">{{ number_format($hasilSaw->nilai_preferensi, 4) }}</div>
                                <div style="font-size:11px; color:#64748b;">Nilai Vi</div>
                            </div>
                            <div>
                                <div style="font-size:22px; font-weight:800; color:#a78bfa;">#{{ $hasilSaw->peringkat }}</div>
                                <div style="font-size:11px; color:#64748b;">Peringkat</div>
                            </div>
                        </div>
                    </div>
                    @endif

                @endif
        </div>
    </div>

</div>

@endsection
