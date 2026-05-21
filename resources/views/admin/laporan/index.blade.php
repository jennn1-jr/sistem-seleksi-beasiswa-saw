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
            <i class="fas fa-file-chart-column" style="font-size: 48px; color: var(--text-muted); display: block; margin-bottom: 16px;"></i>
            <p class="empty-title">Laporan belum tersedia</p>
            <p class="empty-sub">Jalankan eksekusi SAW terlebih dahulu untuk menghasilkan laporan.</p>
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
        <div class="card-header laporan-lolos-header">
            <div class="card-title laporan-lolos-title">
                <i class="fas fa-trophy" style="color: #10b981;"></i>
                Daftar Penerima Beasiswa
                <span class="laporan-lolos-count">
                    {{ $hasil->where('lolos', true)->count() }} mahasiswa
                </span>
            </div>
        </div>
        <div class="table-wrapper overflow-x-auto w-full">
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
                    <tr class="tr-lolos">
                        <td class="td-peringkat">
                            @if($h->peringkat == 1) 🥇
                            @elseif($h->peringkat == 2) 🥈
                            @elseif($h->peringkat == 3) 🥉
                            @else #{{ $h->peringkat }}
                            @endif
                        </td>
                        <td class="td-nim-lolos">{{ $h->pendaftar->nim }}</td>
                        <td class="td-nama-lolos">{{ $h->pendaftar->nama }}</td>
                        <td class="td-prodi">{{ $h->pendaftar->program_studi }}</td>
                        <td class="td-nilai-vi">
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
                <span class="laporan-gagal-count">
                    {{ $hasil->where('lolos', false)->count() }} mahasiswa
                </span>
            </div>
        </div>
        <div class="table-wrapper overflow-x-auto w-full">
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
                        <td class="td-rank-gagal">#{{ $h->peringkat }}</td>
                        <td class="td-nim-gagal">{{ $h->pendaftar->nim }}</td>
                        <td class="td-nama-gagal">{{ $h->pendaftar->nama }}</td>
                        <td class="td-prodi-gagal">{{ $h->pendaftar->program_studi }}</td>
                        <td class="td-nilai-gagal">
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

@push('styles')
<style>
    /* Empty state */
    .empty-title { font-size: 15px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px; }
    .empty-sub   { font-size: 13px; color: var(--text-muted); margin-bottom: 20px; opacity: 0.75; }

    /* Header Lolos (hijau) */
    .laporan-lolos-header { background: #ecfdf5; border-bottom: 2px solid #a7f3d0; }
    .laporan-lolos-title  { color: #065f46; }
    .laporan-lolos-count  { background: #d1fae5; color: #065f46; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
    [data-theme="dark"] .laporan-lolos-header { background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.3); }
    [data-theme="dark"] .laporan-lolos-title  { color: #6ee7b7; }
    [data-theme="dark"] .laporan-lolos-count  { background: rgba(16,185,129,0.2); color: #6ee7b7; }

    /* Count tidak lolos */
    .laporan-gagal-count { background: #fee2e2; color: #991b1b; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
    [data-theme="dark"] .laporan-gagal-count { background: rgba(239,68,68,0.2); color: #fca5a5; }

    /* Baris lolos */
    .tr-lolos { background: #f0fdf4; }
    [data-theme="dark"] .tr-lolos { background: rgba(16,185,129,0.07); }

    /* Sel tabel lolos */
    .td-peringkat  { text-align: center; font-weight: 800; font-size: 16px; color: var(--text); }
    .td-nim-lolos  { font-weight: 600; font-size: 13px; color: var(--text); }
    .td-nama-lolos { font-weight: 500; font-size: 13.5px; color: var(--text); }
    .td-prodi      { font-size: 12px; color: var(--text-muted); }
    .td-nilai-vi   { text-align: center; font-weight: 800; font-size: 15px; color: #7c3aed; }
    [data-theme="dark"] .td-nilai-vi { color: #a78bfa; }

    /* Sel tabel gagal */
    .td-rank-gagal  { text-align: center; font-weight: 700; font-size: 13px; color: var(--text-muted); }
    .td-nim-gagal   { font-size: 13px;   color: var(--text-muted); }
    .td-nama-gagal  { font-size: 13.5px; color: var(--text-muted); }
    .td-prodi-gagal { font-size: 12px;   color: var(--text-muted); opacity: 0.75; }
    .td-nilai-gagal { text-align: center; font-weight: 700; font-size: 14px; color: var(--text-muted); }
</style>
@endpush
