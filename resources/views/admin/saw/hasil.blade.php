@extends('layouts.admin')

@section('title', 'Hasil Peringkat SAW')
@section('page-title', 'Hasil Peringkat SAW')
@section('breadcrumb', 'Hasil perhitungan dan peringkat penerima beasiswa')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Hasil Peringkat SAW</h1>
        <p>
            Kuota: <strong>{{ $kuota }} mahasiswa</strong> &mdash;
            Total diproses: <strong>{{ $hasil->count() }} pendaftar</strong>
            @if($hasil->isNotEmpty())
                &mdash; Dihitung: <strong>{{ $hasil->first()->dieksekusi_at?->format('d M Y, H:i') }} WIB</strong>
            @endif
        </p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.laporan.cetak') }}" target="_blank" class="btn btn-secondary">
            <i class="fas fa-print"></i> Cetak
        </a>
        <a href="{{ route('admin.saw.index') }}" class="btn btn-secondary">
            <i class="fas fa-rotate"></i> Hitung Ulang
        </a>
    </div>
</div>

@if($hasil->isEmpty())
    {{-- ── Belum Ada Hasil ─────────────────────────────── --}}
    <div class="card">
        <div class="card-body" style="padding: 60px; text-align: center;">
            <i class="fas fa-calculator" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 16px;"></i>
            <p style="font-size: 15px; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Belum ada hasil perhitungan</p>
            <p style="font-size: 13px; color: #9ca3af; margin-bottom: 20px;">Jalankan eksekusi SAW terlebih dahulu untuk melihat peringkat.</p>
            <a href="{{ route('admin.saw.index') }}" class="btn btn-primary">
                <i class="fas fa-calculator"></i> Ke Halaman Eksekusi SAW
            </a>
        </div>
    </div>
@else

    {{-- ── Ringkasan Hasil ─────────────────────────────── --}}
    <div class="stat-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-trophy"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $hasil->where('lolos', true)->count() }}</div>
                <div class="stat-label">Lolos Beasiswa</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger" style="background:#fee2e2;">
                <i class="fas fa-circle-xmark" style="color:#ef4444;"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $hasil->where('lolos', false)->count() }}</div>
                <div class="stat-label">Tidak Lolos</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-star"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($hasil->max('nilai_preferensi'), 4) }}</div>
                <div class="stat-label">Nilai Vi Tertinggi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-chart-bar"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($hasil->avg('nilai_preferensi'), 4) }}</div>
                <div class="stat-label">Rata-rata Nilai Vi</div>
            </div>
        </div>
    </div>

    {{-- ── Tabel Hasil Peringkat ────────────────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-ranking-star"></i> Tabel Peringkat
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <span style="display:flex; align-items:center; gap:6px; font-size:12px; color:#065f46; background:#d1fae5; padding:4px 10px; border-radius:20px;">
                    <i class="fas fa-circle" style="font-size:8px;"></i> Lolos (peringkat 1–{{ $kuota }})
                </span>
                <span style="display:flex; align-items:center; gap:6px; font-size:12px; color:#991b1b; background:#fee2e2; padding:4px 10px; border-radius:20px;">
                    <i class="fas fa-circle" style="font-size:8px;"></i> Tidak Lolos
                </span>
            </div>
        </div>

        <div class="table-wrapper overflow-x-auto w-full">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:center; width:50px;">Rank</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Prodi</th>
                        {{-- Kolom Matriks R per Kriteria --}}
                        @foreach($kriteria as $k)
                            <th style="text-align:center; white-space:nowrap;">
                                R<sub>{{ strtolower($k->kode) }}</sub>
                                <div style="font-size:10px; color:#9ca3af; font-weight:400;">({{ $k->kode }})</div>
                            </th>
                        @endforeach
                        <th style="text-align:center; white-space:nowrap;">
                            <span style="font-weight:700; color:#7c3aed;">Nilai V<sub>i</sub></span>
                        </th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil as $h)
                    <tr style="{{ $h->lolos ? 'background: #f0fdf4;' : '' }}">
                        {{-- Peringkat --}}
                        <td style="text-align:center;">
                            @if($h->peringkat <= 3 && $h->lolos)
                                <span style="font-size:18px; font-weight:800;
                                    color: {{ $h->peringkat == 1 ? '#f59e0b' : ($h->peringkat == 2 ? '#9ca3af' : '#b45309') }}">
                                    {{ $h->peringkat == 1 ? '🥇' : ($h->peringkat == 2 ? '🥈' : '🥉') }}
                                </span>
                            @else
                                <span style="font-size:15px; font-weight:700; color:#374151;">#{{ $h->peringkat }}</span>
                            @endif
                        </td>

                        {{-- Data Mahasiswa --}}
                        <td style="font-size:13px; font-weight:600;">{{ $h->pendaftar->nim }}</td>
                        <td>
                            <div style="font-weight:500; font-size:13.5px;">{{ $h->pendaftar->nama }}</div>
                        </td>
                        <td style="font-size:12px; color:#6b7280;">{{ $h->pendaftar->program_studi }}</td>

                        {{-- Nilai R tiap kriteria --}}
                        @foreach($kriteria as $k)
                            @php
                                $rCol = 'r_' . strtolower($k->kode);
                            @endphp
                            <td style="text-align:center; font-size:12px; color:#374151;">
                                {{ number_format($h->$rCol ?? 0, 4) }}
                            </td>
                        @endforeach

                        {{-- Nilai Preferensi Vi --}}
                        <td style="text-align:center;">
                            <span style="font-size:15px; font-weight:800; color:#7c3aed;">
                                {{ number_format($h->nilai_preferensi, 4) }}
                            </span>
                        </td>

                        {{-- Status Lolos --}}
                        <td style="text-align:center;">
                            @if($h->lolos)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Lolos
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-xmark"></i> Tidak Lolos
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer: Batas kuota --}}
        <div style="padding: 14px 20px; border-top: 2px dashed #e5e7eb; background: #fafafa; border-radius: 0 0 12px 12px;">
            <div style="font-size: 12px; color: #6b7280; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-line-columns" style="color: #7c3aed;"></i>
                Garis batas kuota: peringkat <strong>1 – {{ $kuota }}</strong> dinyatakan <strong>lolos</strong> beasiswa.
                Berdasarkan pengaturan kuota sistem.
            </div>
        </div>
    </div>

@endif

@endsection
