@extends('layouts.admin')

@section('title', 'Log Aktivitas Admin')
@section('page-title', 'Log Aktivitas Admin')
@section('breadcrumb', 'Riwayat perubahan data master oleh administrator')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Log Aktivitas Admin</h1>
        <p>Waktu, admin, dan ringkasan aksi pada data master (auditability / NFR SRS).</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-clock-rotate-left"></i>
            Riwayat aktivitas
            <span class="log-count-badge">{{ $logs->count() }} entri</span>
        </div>
    </div>

    <div class="table-wrapper overflow-x-auto w-full">
        @if($logs->isEmpty())
            <div class="log-empty-state">
                <i class="fas fa-clipboard-list"></i>
                <p>Belum ada log aktivitas. Log akan muncul setelah admin menambah atau mengubah data master (misalnya kriteria atau pendaftar).</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width: 170px;">Waktu</th>
                        <th style="width: 200px;">Admin</th>
                        <th style="width: 130px;">Tabel</th>
                        <th>Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>
                            <span class="log-time">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                        </td>
                        <td>
                            @if($log->user)
                                <div class="log-admin-name">{{ $log->user->name }}</div>
                                <div class="log-admin-user">{{ '@' . $log->user->username }}</div>
                            @else
                                <span class="log-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info log-table-badge">{{ $log->tabel_terkait }}</span>
                        </td>
                        <td>
                            <span class="log-aktivitas-text">{{ $log->aktivitas }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .log-count-badge {
        margin-left: 10px;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 999px;
        background: var(--primary-light);
        color: var(--primary);
    }
    [data-theme="dark"] .log-count-badge {
        background: rgba(124,58,237,0.25);
        color: #c4b5fd;
    }
    .log-time {
        font-size: 12.5px;
        font-variant-numeric: tabular-nums;
        color: var(--text-muted);
    }
    .log-admin-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--text);
    }
    .log-admin-user {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .log-table-badge {
        font-size: 11px;
        text-transform: lowercase;
    }
    .log-aktivitas-text {
        font-size: 13px;
        line-height: 1.45;
        color: var(--text);
    }
    .log-muted { color: var(--text-muted); font-size: 13px; }
    .log-empty-state {
        padding: 48px 24px;
        text-align: center;
        color: var(--text-muted);
    }
    .log-empty-state i {
        font-size: 40px;
        margin-bottom: 16px;
        opacity: 0.45;
        color: var(--primary);
    }
    .log-empty-state p {
        max-width: 420px;
        margin: 0 auto;
        font-size: 14px;
        line-height: 1.55;
    }
</style>
@endpush
