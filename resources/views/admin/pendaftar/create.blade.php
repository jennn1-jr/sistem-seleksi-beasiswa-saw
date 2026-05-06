@extends('layouts.admin')

@section('title', 'Tambah Pendaftar')
@section('page-title', 'Tambah Pendaftar')
@section('breadcrumb', 'Input data mahasiswa pendaftar beasiswa baru')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Pendaftar</h1>
        <p>Isi formulir di bawah dengan data mahasiswa pendaftar beasiswa.</p>
    </div>
    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form method="POST" action="{{ route('admin.pendaftar.store') }}">
@csrf

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    {{-- ── Kolom Kiri: Data Profil ─────────────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user"></i> Data Profil Mahasiswa
            </div>
        </div>
        <div class="card-body">

            {{-- NIM --}}
            <div class="form-group">
                <label class="form-label">NIM <span class="required">*</span></label>
                <input type="text" name="nim" class="form-control {{ $errors->has('nim') ? 'is-invalid' : '' }}"
                       value="{{ old('nim') }}" placeholder="Contoh: 25051204294" required>
                @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Nama --}}
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                       value="{{ old('nama') }}" placeholder="Nama lengkap mahasiswa" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Program Studi --}}
            <div class="form-group">
                <label class="form-label">Program Studi <span class="required">*</span></label>
                <input type="text" name="program_studi" class="form-control {{ $errors->has('program_studi') ? 'is-invalid' : '' }}"
                       value="{{ old('program_studi') }}" placeholder="Contoh: Teknik Informatika" required>
                @error('program_studi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Semester --}}
            <div class="form-group">
                <label class="form-label">Semester <span class="required">*</span></label>
                <input type="number" name="semester" class="form-control {{ $errors->has('semester') ? 'is-invalid' : '' }}"
                       value="{{ old('semester') }}" min="1" max="14" placeholder="1 - 14" required>
                @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       value="{{ old('email') }}" placeholder="email@contoh.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- No HP --}}
            <div class="form-group">
                <label class="form-label">No. HP / WhatsApp</label>
                <input type="text" name="no_hp" class="form-control {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                       value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Password Akun Mahasiswa --}}
            <div class="form-group" style="margin-bottom: 0; margin-top: 8px; padding-top: 16px; border-top: 1px dashed #e5e7eb;">
                <label class="form-label">
                    <i class="fas fa-key" style="color:#7c3aed;"></i>
                    Password Login Mahasiswa <span class="required">*</span>
                </label>
                <div style="position: relative;">
                    <input type="password" name="password" id="pwMahasiswa"
                           class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Buat password untuk login mahasiswa" required>
                    <button type="button" onclick="togglePw()"
                            style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                   background:none; border:none; color:#9ca3af; cursor:pointer; font-size:14px;">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                <div class="form-hint">
                    <i class="fas fa-circle-info" style="color:#7c3aed;"></i>
                    Mahasiswa login dengan <strong>NIM</strong> sebagai username dan password ini.
                </div>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>
    </div>

    {{-- ── Kolom Kanan: Nilai Kriteria ────────────────── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-calculator"></i> Nilai Kriteria SAW
            </div>
        </div>
        <div class="card-body">

            <div class="alert alert-info" style="margin-bottom: 20px;">
                <i class="fas fa-circle-info"></i>
                <span>Nilai kriteria digunakan untuk perhitungan SAW. Isi sesuai data asli mahasiswa.</span>
            </div>

            {{-- C1: IPK --}}
            <div class="form-group">
                <label class="form-label">
                    <span class="kriteria-badge">C1</span>
                    Nilai IPK
                    <span style="font-size: 11px; color: #9ca3af; font-weight: 400;">(Benefit · Bobot: 3)</span>
                </label>
                <input type="number" name="ipk" step="0.01" min="0" max="4"
                       class="form-control {{ $errors->has('ipk') ? 'is-invalid' : '' }}"
                       value="{{ old('ipk') }}" placeholder="0.00 – 4.00">
                <div class="form-hint">Skala 0.00 – 4.00</div>
                @error('ipk') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- C2: Penghasilan Orang Tua --}}
            <div class="form-group">
                <label class="form-label">
                    <span class="kriteria-badge cost">C2</span>
                    Penghasilan Orang Tua (Rp)
                    <span style="font-size: 11px; color: #9ca3af; font-weight: 400;">(Cost · Bobot: 4)</span>
                </label>
                <input type="number" name="penghasilan_ortu" min="0"
                       class="form-control {{ $errors->has('penghasilan_ortu') ? 'is-invalid' : '' }}"
                       value="{{ old('penghasilan_ortu') }}" placeholder="Contoh: 1500000">
                <div class="form-hint">Dalam satuan Rupiah per bulan</div>
                @error('penghasilan_ortu') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- C3: Semester Aktif --}}
            <div class="form-group">
                <label class="form-label">
                    <span class="kriteria-badge">C3</span>
                    Semester Aktif
                    <span style="font-size: 11px; color: #9ca3af; font-weight: 400;">(Benefit · Bobot: 1)</span>
                </label>
                <input type="number" name="semester_aktif" min="1" max="14"
                       class="form-control {{ $errors->has('semester_aktif') ? 'is-invalid' : '' }}"
                       value="{{ old('semester_aktif') }}" placeholder="1 – 14">
                @error('semester_aktif') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- C4: Jumlah Tanggungan --}}
            <div class="form-group">
                <label class="form-label">
                    <span class="kriteria-badge">C4</span>
                    Jumlah Tanggungan Orang Tua
                    <span style="font-size: 11px; color: #9ca3af; font-weight: 400;">(Benefit · Bobot: 2)</span>
                </label>
                <input type="number" name="jml_tanggungan" min="0"
                       class="form-control {{ $errors->has('jml_tanggungan') ? 'is-invalid' : '' }}"
                       value="{{ old('jml_tanggungan') }}" placeholder="Jumlah orang">
                <div class="form-hint">Jumlah anggota keluarga yang masih ditanggung</div>
                @error('jml_tanggungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- C5: Keikutsertaan Organisasi --}}
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">
                    <span class="kriteria-badge">C5</span>
                    Keikutsertaan Organisasi
                    <span style="font-size: 11px; color: #9ca3af; font-weight: 400;">(Benefit · Bobot: 5)</span>
                </label>
                <input type="number" name="keikutsertaan_organisasi" min="0"
                       class="form-control {{ $errors->has('keikutsertaan_organisasi') ? 'is-invalid' : '' }}"
                       value="{{ old('keikutsertaan_organisasi') }}" placeholder="Jumlah organisasi">
                <div class="form-hint">Jumlah organisasi yang aktif diikuti</div>
                @error('keikutsertaan_organisasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

        </div>
    </div>

</div>{{-- /grid --}}

{{-- ── Tombol Aksi ──────────────────────────────────────── --}}
<div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-secondary">
        <i class="fas fa-xmark"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-floppy-disk"></i> Simpan Data
    </button>
</div>

</form>

@endsection

@push('styles')
<style>
    /* ── Form Styles ───────────────────────────────── */
    .form-group {
        margin-bottom: 16px;
    }
    .form-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 6px;
    }
    .required { color: #ef4444; }
    .form-control {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1f2937;
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: 12px; color: #ef4444; margin-top: 4px; }
    .form-hint { font-size: 11.5px; color: #9ca3af; margin-top: 4px; }

    /* ── Kriteria Badge ─────────────────────────────── */
    .kriteria-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 20px;
        background: #7c3aed;
        color: #fff;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .kriteria-badge.cost { background: #ef4444; }
</style>
@endpush

@push('scripts')
<script>
    function togglePw() {
        const input = document.getElementById('pwMahasiswa');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endpush
