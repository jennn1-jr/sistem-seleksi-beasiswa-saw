@extends('layouts.admin')

@section('title', 'Laporan Hasil Seleksi')
@section('page-title', 'Laporan Hasil Seleksi')
@section('breadcrumb', 'Rekap hasil seleksi ' . $namaBeasiswa . ' — Periode ' . $periodeAktif)

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Laporan Hasil Seleksi</h1>
        <p>Rekap hasil seleksi <strong>{{ $namaBeasiswa }}</strong> — Periode <strong>{{ $periodeAktif }}</strong></p>
    </div>
    @if($hasil->isNotEmpty())
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.laporan.cetak') }}" target="_blank" class="btn btn-secondary">
            <i class="fas fa-print"></i> Cetak Laporan
        </a>
        <a href="{{ route('admin.laporan.export-pdf') }}" class="btn btn-primary">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
    @endif
</div>

@if($hasil->isEmpty())
    {{-- Belum Ada Data --}}
    <div class="card">
        <div class="card-body" style="padding: 60px; text-align: center;">
            <i class="fas fa-file-chart-column" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 16px;"></i>
            <p style="font-size: 15px; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Laporan belum tersedia</p>
            <p style="font-size: 13px; color: #9ca3af; margin-bottom: 20px;">Jalankan eksekusi SAW terlebih dahulu untuk menghasilkan laporan.</p>
            <a href="{{ route('admin.saw.index') }}" class="btn btn-primary">
                <i class="fas fa-calculator"></i> Ke Eksekusi SAW
            </a>
        </div>
    </div>

@else

    {{-- ── Stat Cards ───────────────────────────────────── --}}
    <div class="stat-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $hasil->count() }}</div>
                <div class="stat-label">Total Diseleksi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-trophy"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $hasil->where('lolos', true)->count() }}</div>
                <div class="stat-label">Penerima Beasiswa</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="fas fa-circle-xmark"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $hasil->where('lolos', false)->count() }}</div>
                <div class="stat-label">Tidak Lolos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-award"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $kuota }}</div>
                <div class="stat-label">Kuota Beasiswa</div>
            </div>
        </div>
    </div>

    {{-- ── Tabel Penerima Beasiswa ──────────────────────── --}}
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header" style="background: #ecfdf5; border-bottom: 2px solid #a7f3d0;">
            <div class="card-title" style="color: #065f46;">
                <i class="fas fa-trophy" style="color: #10b981;"></i>
                Daftar Penerima Beasiswa
                <span style="background: #d1fae5; color: #065f46; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                    {{ $hasil->where('lolos', true)->count() }} mahasiswa
                </span>
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center; width:50px;">Peringkat</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th style="text-align:center;">Nilai Vi</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil->where('lolos', true) as $h)
                    <tr style="background: #f0fdf4;">
                        <td style="text-align:center; font-weight:800; font-size:16px; color:#374151;">
                            @if($h->peringkat == 1) 🥇
                            @elseif($h->peringkat == 2) 🥈
                            @elseif($h->peringkat == 3) 🥉
                            @else #{{ $h->peringkat }}
                            @endif
                        </td>
                        <td style="font-weight:600; font-size:13px;">{{ $h->pendaftar->nim }}</td>
                        <td style="font-weight:500; font-size:13.5px;">{{ $h->pendaftar->nama }}</td>
                        <td style="font-size:12px; color:#6b7280;">{{ $h->pendaftar->program_studi }}</td>
                        <td style="text-align:center; font-weight:800; font-size:15px; color:#7c3aed;">
                            {{ number_format($h->nilai_preferensi, 4) }}
                        </td>
                        <td style="text-align:center;">
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Lolos
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Tabel Tidak Lolos ────────────────────────────── --}}
    @if($hasil->where('lolos', false)->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-circle-xmark" style="color: #ef4444;"></i>
                Tidak Lolos Seleksi
                <span style="background: #fee2e2; color: #991b1b; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                    {{ $hasil->where('lolos', false)->count() }} mahasiswa
                </span>
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center; width:50px;">Peringkat</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th style="text-align:center;">Nilai Vi</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil->where('lolos', false) as $h)
                    <tr>
                        <td style="text-align:center; font-weight:700; font-size:13px; color:#9ca3af;">#{{ $h->peringkat }}</td>
                        <td style="font-size:13px; color:#6b7280;">{{ $h->pendaftar->nim }}</td>
                        <td style="font-size:13.5px; color:#6b7280;">{{ $h->pendaftar->nama }}</td>
                        <td style="font-size:12px; color:#9ca3af;">{{ $h->pendaftar->program_studi }}</td>
                        <td style="text-align:center; font-weight:700; font-size:14px; color:#9ca3af;">
                            {{ number_format($h->nilai_preferensi, 4) }}
                        </td>
                        <td style="text-align:center;">
                            <span class="badge badge-danger">
                                <i class="fas fa-xmark"></i> Tidak Lolos
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

@endif

@endsection
