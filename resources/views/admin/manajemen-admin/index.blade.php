@extends('layouts.admin')

@section('title', 'Manajemen Admin')
@section('page-title', 'Manajemen Admin')
@section('breadcrumb', 'Kelola akun administrator sistem beasiswa')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Manajemen Admin</h1>
        <p>Daftar seluruh akun administrator yang dapat mengakses sistem ini.</p>
    </div>
    <a href="{{ route('admin.manajemen-admin.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Admin
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-user-shield"></i>
            Daftar Administrator
            <span style="background:#ede9fe; color:#7c3aed; font-size:11px; padding:2px 8px; border-radius:20px; font-weight:600;">
                {{ $admins->count() }} akun
            </span>
        </div>
    </div>

    <div class="table-wrapper">
        @if($admins->isEmpty())
            <div style="padding: 56px; text-align: center; color: #9ca3af;">
                <i class="fas fa-user-slash" style="font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                <p style="font-size: 14px;">Belum ada akun admin.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th style="text-align:center;">Role</th>
                        <th style="text-align:center;">Tgl. Dibuat</th>
                        <th style="text-align:center; width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $i => $admin)
                    <tr>
                        <td style="color:#9ca3af; font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                {{-- Avatar inisial --}}
                                <div style="width:36px; height:36px; border-radius:50%;
                                            background: linear-gradient(135deg, #7c3aed, #5b21b6);
                                            color:#fff; display:flex; align-items:center;
                                            justify-content:center; font-size:13px; font-weight:700;
                                            flex-shrink:0;">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:500; font-size:13.5px;">{{ $admin->name }}</div>
                                    @if($admin->id === Auth::id())
                                        <div style="font-size:11px; color:#7c3aed; font-weight:600;">
                                            <i class="fas fa-circle-check"></i> Akun Anda
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <code style="background:#f3f4f6; padding:3px 8px; border-radius:6px;
                                         font-size:12.5px; color:#374151;">
                                {{ $admin->username }}
                            </code>
                        </td>
                        <td style="text-align:center;">
                            <span class="badge badge-purple">
                                <i class="fas fa-shield-halved"></i> Administrator
                            </span>
                        </td>
                        <td style="text-align:center; font-size:12px; color:#6b7280;">
                            {{ $admin->created_at->format('d M Y') }}
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; gap:4px; justify-content:center;">
                                <a href="{{ route('admin.manajemen-admin.edit', $admin->id) }}"
                                   class="btn btn-secondary btn-sm btn-icon" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if($admin->id !== Auth::id())
                                    <form method="POST"
                                          action="{{ route('admin.manajemen-admin.destroy', $admin->id) }}"
                                          onsubmit="return confirm('Hapus akun {{ $admin->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- Tombol hapus disabled untuk akun sendiri --}}
                                    <button class="btn btn-secondary btn-sm btn-icon"
                                            disabled title="Tidak bisa menghapus akun sendiri"
                                            style="opacity:0.4; cursor:not-allowed;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Info keamanan --}}
    <div style="padding:12px 20px; border-top:1px solid #e5e7eb; background:#fafafa;
                border-radius: 0 0 12px 12px;">
        <div style="font-size:12px; color:#9ca3af; display:flex; align-items:center; gap:6px;">
            <i class="fas fa-shield" style="color:#7c3aed;"></i>
            Akun yang sedang login tidak bisa dihapus. Pastikan selalu ada minimal 1 akun admin aktif.
        </div>
    </div>
</div>

@endsection
