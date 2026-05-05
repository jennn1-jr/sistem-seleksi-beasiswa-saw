@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')
@section('breadcrumb', 'Buat akun administrator baru')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Admin</h1>
        <p>Buat akun administrator baru yang dapat mengakses panel sistem beasiswa.</p>
    </div>
    <a href="{{ route('admin.manajemen-admin.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user-plus"></i> Data Akun Admin Baru
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.manajemen-admin.store') }}">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name') }}"
                           placeholder="Contoh: Budi Santoso" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label class="form-label">Username <span class="required">*</span></label>
                    <input type="text" name="username"
                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                           value="{{ old('username') }}"
                           placeholder="Contoh: budi.santoso" required>
                    <div class="form-hint">Username digunakan untuk login. Tidak boleh sama dengan akun lain.</div>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Minimal 6 karakter" required>
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('password', 'eyePassword')"
                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; color:#9ca3af; cursor:pointer; font-size:14px;">
                            <i class="fas fa-eye" id="eyePassword"></i>
                        </button>
                    </div>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                    <div style="position: relative;">
                        <input type="password" name="password_confirmation" id="passwordConfirm"
                               class="form-control"
                               placeholder="Ulangi password" required>
                        <button type="button" class="btn-toggle-pw" onclick="togglePw('passwordConfirm', 'eyeConfirm')"
                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; color:#9ca3af; cursor:pointer; font-size:14px;">
                            <i class="fas fa-eye" id="eyeConfirm"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px;
                            margin-top:24px; padding-top:16px; border-top:1px solid #e5e7eb;">
                    <a href="{{ route('admin.manajemen-admin.index') }}" class="btn btn-secondary">
                        <i class="fas fa-xmark"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Buat Akun Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 18px; }
    .form-label { font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; display:flex; align-items:center; gap:6px; }
    .required { color: #ef4444; }
    .form-control {
        width:100%; padding:9px 12px;
        border:1px solid #e5e7eb; border-radius:8px;
        font-size:13.5px; font-family:inherit; color:#1f2937;
        background:#fff; outline:none;
        transition:border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus { border-color:#7c3aed; box-shadow:0 0 0 3px rgba(124,58,237,0.1); }
    .form-control.is-invalid { border-color:#ef4444; }
    .invalid-feedback { font-size:12px; color:#ef4444; margin-top:4px; }
    .form-hint { font-size:11.5px; color:#9ca3af; margin-top:4px; }
</style>
@endpush

@push('scripts')
<script>
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
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
