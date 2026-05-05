@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('breadcrumb', 'Ubah data akun administrator')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Admin</h1>
        <p>Ubah data akun administrator: <strong>{{ $admin->name }}</strong></p>
    </div>
    <a href="{{ route('admin.manajemen-admin.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 520px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                {{-- Avatar inisial --}}
                <div style="width:32px; height:32px; border-radius:50%;
                            background: linear-gradient(135deg, #7c3aed, #5b21b6);
                            color:#fff; display:flex; align-items:center;
                            justify-content:center; font-size:13px; font-weight:700; flex-shrink:0;">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                {{ $admin->name }}
            </div>
            @if($admin->id === Auth::id())
                <span class="badge badge-purple"><i class="fas fa-circle-check"></i> Akun Anda</span>
            @endif
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.manajemen-admin.update', $admin->id) }}">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name"
                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name', $admin->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label class="form-label">Username <span class="required">*</span></label>
                    <input type="text" name="username"
                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                           value="{{ old('username', $admin->username) }}" required>
                    <div class="form-hint">Tidak boleh sama dengan akun admin lain.</div>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Divider ganti password --}}
                <div style="border-top: 1px dashed #e5e7eb; margin: 20px 0; padding-top: 16px;">
                    <p style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase;
                              letter-spacing:0.5px; margin-bottom:12px;">
                        <i class="fas fa-key" style="color:#7c3aed;"></i> Ganti Password
                    </p>
                    <div class="alert alert-info" style="margin-bottom:16px;">
                        <i class="fas fa-circle-info"></i>
                        <span>Kosongkan jika tidak ingin mengganti password.</span>
                    </div>
                </div>

                {{-- Password Baru --}}
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Kosongkan jika tidak diganti">
                        <button type="button" onclick="togglePw('password','eyePass')"
                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; color:#9ca3af; cursor:pointer; font-size:14px;">
                            <i class="fas fa-eye" id="eyePass"></i>
                        </button>
                    </div>
                    <div class="form-hint">Minimal 6 karakter.</div>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div style="position: relative;">
                        <input type="password" name="password_confirmation" id="passwordConfirm"
                               class="form-control"
                               placeholder="Ulangi password baru">
                        <button type="button" onclick="togglePw('passwordConfirm','eyeConfirm')"
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
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
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
    .required { color:#ef4444; }
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
