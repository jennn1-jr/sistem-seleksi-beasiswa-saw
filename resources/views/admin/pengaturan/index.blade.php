@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')
@section('breadcrumb', 'Atur konfigurasi dasar sistem beasiswa')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pengaturan Sistem</h1>
        <p>Konfigurasi dasar sistem seleksi beasiswa yang akan digunakan dalam proses SAW.</p>
    </div>
</div>

<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-gear"></i> Konfigurasi Sistem
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.pengaturan.update') }}">
                @csrf

                {{-- Nama Beasiswa --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-graduation-cap" style="color:#7c3aed; width:16px;"></i>
                        Nama Program Beasiswa <span class="required">*</span>
                    </label>
                    <input type="text" name="nama_beasiswa"
                           class="form-control {{ $errors->has('nama_beasiswa') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_beasiswa', $namaBeasiswa) }}"
                           placeholder="Contoh: Beasiswa PPA" required>
                    <div class="form-hint">Nama ini akan tampil di laporan dan halaman mahasiswa.</div>
                    @error('nama_beasiswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Kuota Beasiswa --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-users" style="color:#7c3aed; width:16px;"></i>
                        Kuota Penerima Beasiswa <span class="required">*</span>
                    </label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="number" name="kuota_beasiswa" min="1" max="100"
                               class="form-control {{ $errors->has('kuota_beasiswa') ? 'is-invalid' : '' }}"
                               value="{{ old('kuota_beasiswa', $kuota) }}"
                               style="max-width: 120px;" required>
                        <span style="font-size: 13px; color: #6b7280;">mahasiswa</span>
                    </div>
                    <div class="form-hint">
                        Jumlah mahasiswa yang akan diterima. Peringkat 1 s/d <strong>{{ $kuota }}</strong> akan dinyatakan lolos SAW.
                    </div>
                    @error('kuota_beasiswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Periode Aktif --}}
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">
                        <i class="fas fa-calendar" style="color:#7c3aed; width:16px;"></i>
                        Periode / Tahun Aktif <span class="required">*</span>
                    </label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="number" name="periode_aktif"
                               min="2020" max="2099"
                               class="form-control {{ $errors->has('periode_aktif') ? 'is-invalid' : '' }}"
                               value="{{ old('periode_aktif', $periodeAktif) }}"
                               style="max-width: 120px;" required>
                        <span style="font-size: 13px; color: #6b7280;">/ {{ (int)$periodeAktif + 1 }}</span>
                    </div>
                    <div class="form-hint">Tahun akademik aktif untuk seleksi beasiswa ini.</div>
                    @error('periode_aktif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div style="padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e7eb;
                            display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-floppy-disk"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Info Box ─────────────────────────────────── --}}
    <div class="alert alert-info" style="margin-top: 20px;">
        <i class="fas fa-circle-info"></i>
        <div>
            <strong>Catatan Penting:</strong>
            <ul style="margin: 6px 0 0 16px; font-size: 12.5px; line-height: 1.8;">
                <li>Perubahan kuota akan langsung berlaku pada perhitungan SAW berikutnya.</li>
                <li>Hasil SAW yang sudah ada <strong>tidak berubah otomatis</strong> — perlu hitung ulang jika kuota diubah.</li>
                <li>Periode aktif digunakan sebagai label pada laporan cetak.</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 7px;
    }
    .required { color: #ef4444; }
    .form-control {
        width: 100%; padding: 9px 12px;
        border: 1px solid #e5e7eb; border-radius: 8px;
        font-size: 13.5px; font-family: inherit; color: #1f2937;
        background: #fff; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: 12px; color: #ef4444; margin-top: 4px; }
    .form-hint { font-size: 11.5px; color: #9ca3af; margin-top: 5px; line-height: 1.5; }
</style>
@endpush
