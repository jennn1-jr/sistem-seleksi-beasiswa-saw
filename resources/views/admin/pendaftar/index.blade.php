@extends('layouts.admin')

@section('title', 'Data Pendaftar')
@section('page-title', 'Data Pendaftar')
@section('breadcrumb', 'Kelola data mahasiswa pendaftar beasiswa')

@section('content')

{{-- ── Page Header ───────────────────────────────────────── --}}
<div class="page-header">
    <div class="page-header-left">
        <h1>Data Pendaftar</h1>
        <p>Daftar seluruh mahasiswa yang mendaftar beasiswa — Periode {{ date('Y') }}</p>
    </div>
    <a href="{{ route('admin.pendaftar.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pendaftar
    </a>
</div>

{{-- ── Filter & Search Bar ────────────────────────────────── --}}
<div class="card" style="margin-bottom: 20px;">
    <div class="card-body" style="padding: 14px 20px;">
        <form method="GET" action="{{ route('admin.pendaftar.index') }}"
              style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">

            <div style="flex: 1; min-width: 200px; position: relative;">
                <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau NIM..."
                       style="width:100%; padding: 8px 12px 8px 34px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; outline: none;">
            </div>

            <select name="status"
                    style="padding: 8px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-family: inherit; color: #374151; background: #fff; outline: none; cursor: pointer;">
                <option value="">Semua Status</option>
                <option value="pending"       {{ request('status') === 'pending'       ? 'selected' : '' }}>Pending</option>
                <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="ditolak"       {{ request('status') === 'ditolak'       ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-filter"></i> Filter
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-xmark"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

{{-- ── Tabel Data Pendaftar ────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-users"></i>
            Daftar Pendaftar
            <span style="background: #ede9fe; color: #7c3aed; font-size: 11px; padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                {{ $pendaftar->total() }} data
            </span>
        </div>
    </div>

    <div class="table-wrapper">
        @if($pendaftar->isEmpty())
            <div style="padding: 56px; text-align: center; color: #9ca3af;">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.4;"></i>
                <p style="font-size: 15px; font-weight: 500; margin-bottom: 8px; color: #6b7280;">Belum ada data pendaftar</p>
                <p style="font-size: 13px; margin-bottom: 20px;">Tambahkan data mahasiswa pendaftar beasiswa untuk memulai seleksi.</p>
                <a href="{{ route('admin.pendaftar.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pendaftar Pertama
                </a>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th style="text-align:center">Smt</th>
                        <th style="text-align:center">Nilai Lengkap</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:center">Tgl Daftar</th>
                        <th style="text-align:center; width:120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftar as $i => $p)
                    <tr>
                        <td style="color: #9ca3af; font-size: 12px;">
                            {{ $pendaftar->firstItem() + $i }}
                        </td>
                        <td>
                            <span style="font-weight: 600; font-size: 13px; color: #374151;">{{ $p->nim }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 500; font-size: 13.5px;">{{ $p->nama }}</div>
                            @if($p->email)
                                <div style="font-size: 11px; color: #9ca3af;">{{ $p->email }}</div>
                            @endif
                        </td>
                        <td style="font-size: 13px; color: #6b7280;">{{ $p->program_studi }}</td>
                        <td style="text-align:center; font-size: 13px;">{{ $p->semester }}</td>
                        <td style="text-align:center;">
                            @if($p->nilaiLengkap())
                                <span class="badge badge-success"><i class="fas fa-check"></i> Lengkap</span>
                            @else
                                <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Belum</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
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
                        <td style="text-align:center; font-size: 12px; color: #6b7280;">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                        <td style="text-align:center;">
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                <a href="{{ route('admin.pendaftar.show', $p->id) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pendaftar.edit', $p->id) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.pendaftar.destroy', $p->id) }}"
                                      onsubmit="return confirm('Hapus data {{ $p->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($pendaftar->hasPages())
                <div style="padding: 16px 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <div style="font-size: 13px; color: #6b7280;">
                        Menampilkan {{ $pendaftar->firstItem() }}–{{ $pendaftar->lastItem() }}
                        dari {{ $pendaftar->total() }} data
                    </div>
                    <div style="display: flex; gap: 4px;">
                        {{ $pendaftar->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

@endsection
