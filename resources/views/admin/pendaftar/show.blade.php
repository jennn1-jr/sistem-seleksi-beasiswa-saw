@extends('layouts.admin')

@section('title', 'Detail Pendaftar')
@section('page-title', 'Detail Pendaftar')
@section('breadcrumb', 'Informasi lengkap data pendaftar beasiswa')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Detail Pendaftar</h1>
        <p>{{ $pendaftar->nama }} &mdash; {{ $pendaftar->nim }}</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.pendaftar.edit', $pendaftar->id) }}" class="btn btn-secondary">
            <i class="fas fa-pen"></i> Edit
        </a>
        <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- ── Kolom Kiri ───────────────────────────────────── --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Card: Profil Mahasiswa --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user"></i> Profil Mahasiswa
                </div>
                {{-- Badge Status --}}
                @if($pendaftar->status_verifikasi === 'terverifikasi')
                    <span class="badge badge-success"><i class="fas fa-circle-check"></i> Terverifikasi</span>
                @elseif($pendaftar->status_verifikasi === 'pending')
                    <span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>
                @else
                    <span class="badge badge-danger"><i class="fas fa-circle-xmark"></i> Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="overflow-x-auto w-full">
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">NIM</td>
                            <td class="detail-value"><strong>{{ $pendaftar->nim }}</strong></td>
                        </tr>
                        <tr>
                            <td class="detail-label">Nama Lengkap</td>
                            <td class="detail-value">{{ $pendaftar->nama }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Program Studi</td>
                            <td class="detail-value">{{ $pendaftar->program_studi }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Semester</td>
                            <td class="detail-value">Semester {{ $pendaftar->semester }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Email</td>
                            <td class="detail-value">{{ $pendaftar->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">No. HP</td>
                            <td class="detail-value">{{ $pendaftar->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Tgl. Daftar</td>
                            <td class="detail-value">{{ $pendaftar->created_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        @if($pendaftar->verified_at)
                        <tr>
                            <td class="detail-label">Tgl. Verifikasi</td>
                            <td class="detail-value">{{ $pendaftar->verified_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        @endif
                        @if($pendaftar->catatan_verifikasi)
                        <tr>
                            <td class="detail-label">Catatan</td>
                            <td class="detail-value" style="color: #ef4444;">{{ $pendaftar->catatan_verifikasi }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Card: Aksi Verifikasi (FR-07) --}}
        @if($pendaftar->isPending() || $pendaftar->isDitolak())
        <div class="card" style="border: 2px solid #fde68a;">
            <div class="card-header" style="background: #fffbeb;">
                <div class="card-title">
                    <i class="fas fa-shield-check" style="color: #f59e0b;"></i>
                    Verifikasi Data
                </div>
            </div>
            <div class="card-body">
                @if(!$pendaftar->nilaiLengkap())
                    <div class="alert alert-warning">
                        <i class="fas fa-triangle-exclamation"></i>
                        <span>Nilai kriteria belum lengkap. Lengkapi C1-C5 sebelum verifikasi.</span>
                    </div>
                @else
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 16px;">
                        Klik tombol di bawah untuk memverifikasi data ini agar dapat diikutkan dalam perhitungan SAW.
                    </p>
                    <form method="POST" action="{{ route('admin.pendaftar.verifikasi', $pendaftar->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%;">
                            <i class="fas fa-circle-check"></i> Verifikasi Data Ini
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif

        @if($pendaftar->isVerified())
        <div class="card" style="border: 2px solid #a7f3d0;">
            <div class="card-header" style="background: #ecfdf5;">
                <div class="card-title">
                    <i class="fas fa-shield-check" style="color: #10b981;"></i>
                    Data Terverifikasi
                </div>
            </div>
            <div class="card-body">
                <p style="font-size: 13px; color: #065f46; margin-bottom: 16px;">
                    Data ini sudah diverifikasi dan siap diikutkan dalam perhitungan SAW.
                </p>
                <form method="POST" action="{{ route('admin.pendaftar.tolak', $pendaftar->id) }}"
                      onsubmit="return confirm('Batalkan verifikasi data ini?')">
                    @csrf
                    <input type="hidden" name="catatan" value="Verifikasi dibatalkan oleh admin.">
                    <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">
                        <i class="fas fa-circle-xmark"></i> Batalkan Verifikasi
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>

    {{-- ── Kolom Kanan: Nilai Kriteria ─────────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-calculator"></i> Nilai Kriteria SAW
            </div>
            @if($pendaftar->nilaiLengkap())
                <span class="badge badge-success"><i class="fas fa-check"></i> Lengkap</span>
            @else
                <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Belum Lengkap</span>
            @endif
        </div>
        <div class="card-body">

            <div class="kriteria-list">

                {{-- C1: IPK --}}
                <div class="kriteria-item">
                    <div class="kriteria-left">
                        <span class="kriteria-badge">C1</span>
                        <div>
                            <div class="kriteria-nama">Nilai IPK</div>
                            <div class="kriteria-tipe benefit">Benefit · Bobot 3</div>
                        </div>
                    </div>
                    <div class="kriteria-nilai">
                        {{ $pendaftar->ipk !== null ? number_format($pendaftar->ipk, 2) : '-' }}
                    </div>
                </div>

                {{-- C2: Penghasilan --}}
                <div class="kriteria-item">
                    <div class="kriteria-left">
                        <span class="kriteria-badge cost">C2</span>
                        <div>
                            <div class="kriteria-nama">Penghasilan Orang Tua</div>
                            <div class="kriteria-tipe cost">Cost · Bobot 4</div>
                        </div>
                    </div>
                    <div class="kriteria-nilai">
                        {{ $pendaftar->penghasilan_ortu !== null
                            ? 'Rp ' . number_format($pendaftar->penghasilan_ortu, 0, ',', '.')
                            : '-' }}
                    </div>
                </div>

                {{-- C3: Semester --}}
                <div class="kriteria-item">
                    <div class="kriteria-left">
                        <span class="kriteria-badge">C3</span>
                        <div>
                            <div class="kriteria-nama">Semester Aktif</div>
                            <div class="kriteria-tipe benefit">Benefit · Bobot 1</div>
                        </div>
                    </div>
                    <div class="kriteria-nilai">
                        {{ $pendaftar->semester_aktif !== null ? 'Semester ' . $pendaftar->semester_aktif : '-' }}
                    </div>
                </div>

                {{-- C4: Tanggungan --}}
                <div class="kriteria-item">
                    <div class="kriteria-left">
                        <span class="kriteria-badge">C4</span>
                        <div>
                            <div class="kriteria-nama">Jumlah Tanggungan</div>
                            <div class="kriteria-tipe benefit">Benefit · Bobot 2</div>
                        </div>
                    </div>
                    <div class="kriteria-nilai">
                        {{ $pendaftar->jml_tanggungan !== null ? $pendaftar->jml_tanggungan . ' orang' : '-' }}
                    </div>
                </div>

                {{-- C5: Organisasi --}}
                <div class="kriteria-item" style="border-bottom: none;">
                    <div class="kriteria-left">
                        <span class="kriteria-badge">C5</span>
                        <div>
                            <div class="kriteria-nama">Keikutsertaan Organisasi</div>
                            <div class="kriteria-tipe benefit">Benefit · Bobot 5</div>
                        </div>
                    </div>
                    <div class="kriteria-nilai">
                        {{ $pendaftar->keikutsertaan_organisasi !== null
                            ? $pendaftar->keikutsertaan_organisasi . ' organisasi'
                            : '-' }}
                    </div>
                </div>

            </div>

            {{-- Hasil SAW (jika sudah dihitung) --}}
            @if($pendaftar->hasilSaw)
            <div style="margin-top: 20px; padding: 16px; background: #ede9fe; border-radius: 10px; border: 1px solid #c4b5fd;">
                <div style="font-size: 12px; font-weight: 600; color: #5b21b6; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fas fa-trophy"></i> Hasil Perhitungan SAW
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; text-align: center;">
                    <div>
                        <div style="font-size: 22px; font-weight: 800; color: #7c3aed;">
                            {{ number_format($pendaftar->hasilSaw->nilai_preferensi, 4) }}
                        </div>
                        <div style="font-size: 11px; color: #6b7280;">Nilai Vi</div>
                    </div>
                    <div>
                        <div style="font-size: 22px; font-weight: 800; color: #7c3aed;">
                            #{{ $pendaftar->hasilSaw->peringkat }}
                        </div>
                        <div style="font-size: 11px; color: #6b7280;">Peringkat</div>
                    </div>
                    <div>
                        @if($pendaftar->hasilSaw->lolos)
                            <div style="font-size: 14px; font-weight: 700; color: #065f46; background: #d1fae5; padding: 6px 12px; border-radius: 20px;">
                                <i class="fas fa-check"></i> LOLOS
                            </div>
                        @else
                            <div style="font-size: 14px; font-weight: 700; color: #991b1b; background: #fee2e2; padding: 6px 12px; border-radius: 20px;">
                                <i class="fas fa-xmark"></i> TIDAK LOLOS
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@endsection

@push('styles')
<style>
    /* Detail table */
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table tr { border-bottom: 1px solid #f3f4f6; }
    .detail-table tr:last-child { border-bottom: none; }
    .detail-label {
        padding: 10px 0;
        font-size: 12px;
        font-weight: 500;
        color: #9ca3af;
        width: 40%;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        vertical-align: top;
    }
    .detail-value {
        padding: 10px 0;
        font-size: 13.5px;
        color: #1f2937;
    }

    /* Kriteria list */
    .kriteria-list { display: flex; flex-direction: column; }
    .kriteria-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #f3f4f6;
        gap: 12px;
    }
    .kriteria-left { display: flex; align-items: center; gap: 12px; }
    .kriteria-nama { font-size: 13.5px; font-weight: 500; color: #1f2937; }
    .kriteria-tipe {
        font-size: 11px;
        font-weight: 500;
        margin-top: 2px;
    }
    .kriteria-tipe.benefit { color: #059669; }
    .kriteria-tipe.cost    { color: #ef4444; }
    .kriteria-nilai {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        text-align: right;
    }

    /* Badge kriteria */
    .kriteria-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #7c3aed;
        color: #fff;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .kriteria-badge.cost { background: #ef4444; }
</style>
@endpush
