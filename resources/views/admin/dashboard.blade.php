@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name)

@section('content')

{{-- ── Stat Cards (SRS: Section 3.1.2.1) ──────────────────── --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_pendaftar'] }}</div>
            <div class="stat-label">Total Pendaftar</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['terverifikasi'] }}</div>
            <div class="stat-label">Terverifikasi</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-list-check"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['kriteria_aktif'] }}</div>
            <div class="stat-label">Kriteria Aktif</div>
        </div>
    </div>

</div>

{{-- ── Info Banner Kuota ────────────────────────────────────── --}}
<div style="background: linear-gradient(135deg, #7c3aed, #5b21b6); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
    <div style="color: #fff;">
        <div style="font-size: 13px; opacity: 0.8; margin-bottom: 4px;">Kuota Penerima Beasiswa PPA — Periode {{ date('Y') }}</div>
        <div style="font-size: 22px; font-weight: 800;">{{ $stats['kuota_beasiswa'] }} Mahasiswa</div>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <div style="background: rgba(255,255,255,0.15); border-radius: 8px; padding: 10px 16px; text-align: center;">
            <div style="color: #fff; font-size: 20px; font-weight: 700;">{{ $stats['terverifikasi'] }}</div>
            <div style="color: rgba(255,255,255,0.75); font-size: 11px;">Siap Diproses</div>
        </div>
        <a href="{{ route('admin.saw.index') }}"
           style="background: #fff; color: #7c3aed; border-radius: 8px; padding: 10px 18px; font-weight: 600; font-size: 13px; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: opacity 0.2s;"
           onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
            <i class="fas fa-calculator"></i> Eksekusi SAW
        </a>
    </div>
</div>

{{-- ── Tabel Pendaftar Terbaru ──────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-clock-rotate-left"></i>
            Pendaftar Terbaru
        </div>
        <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-right"></i> Lihat Semua
        </a>
    </div>

    <div class="table-wrapper">
        @if($pendaftar_terbaru->isEmpty())
            <div style="padding: 48px; text-align: center; color: #9ca3af;">
                <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 14px; margin: 0;">Belum ada data pendaftar.</p>
                <a href="{{ route('admin.pendaftar.create') }}" class="btn btn-primary btn-sm" style="margin-top: 12px;">
                    <i class="fas fa-plus"></i> Tambah Pendaftar
                </a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftar_terbaru as $i => $p)
                    <tr>
                        <td style="color: #9ca3af; font-size: 12px;">{{ $i + 1 }}</td>
                        <td><strong>{{ $p->nim }}</strong></td>
                        <td>{{ $p->nama }}</td>
                        <td style="color: #6b7280; font-size: 13px;">{{ $p->program_studi }}</td>
                        <td>
                            @if($p->status_verifikasi === 'terverifikasi')
                                <span class="badge badge-success">
                                    <i class="fas fa-circle-check"></i> Terverifikasi
                                </span>
                            @elseif($p->status_verifikasi === 'pending')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-circle-xmark"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td style="color: #6b7280; font-size: 12px;">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.pendaftar.show', $p->id) }}"
                               class="btn btn-secondary btn-sm btn-icon" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
