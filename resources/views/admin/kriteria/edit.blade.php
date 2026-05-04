@extends('layouts.admin')

@section('title', 'Edit Kriteria')
@section('page-title', 'Edit Kriteria')
@section('breadcrumb', 'Ubah bobot dan tipe kriteria penilaian')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Kriteria</h1>
        <p>Ubah bobot dan tipe untuk kriteria <strong>{{ $kriteria->kode }} — {{ $kriteria->nama }}</strong></p>
    </div>
    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="max-width: 560px;">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span style="display:inline-flex; align-items:center; justify-content:center;
                             width:32px; height:32px; border-radius:8px; font-size:12px;
                             font-weight:700; color:#fff;
                             background: {{ $kriteria->isBenefit() ? '#7c3aed' : '#ef4444' }};">
                    {{ $kriteria->kode }}
                </span>
                {{ $kriteria->nama }}
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.kriteria.update', $kriteria->id) }}">
                @csrf
                @method('PUT')

                {{-- Kode (readonly) --}}
                <div class="form-group">
                    <label class="form-label">Kode Kriteria</label>
                    <input type="text" class="form-control"
                           value="{{ $kriteria->kode }}" readonly
                           style="background: #f9fafb; color: #6b7280; cursor: not-allowed;">
                    <div class="form-hint">Kode kriteria tidak dapat diubah.</div>
                </div>

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label">Nama Kriteria <span class="required">*</span></label>
                    <input type="text" name="nama"
                           class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                           value="{{ old('nama', $kriteria->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Tipe --}}
                <div class="form-group">
                    <label class="form-label">Tipe Kriteria <span class="required">*</span></label>
                    <div style="display: flex; gap: 12px; margin-top: 4px;">
                        <label class="radio-card {{ old('tipe', $kriteria->tipe) === 'benefit' ? 'selected' : '' }}"
                               id="labelBenefit">
                            <input type="radio" name="tipe" value="benefit"
                                   {{ old('tipe', $kriteria->tipe) === 'benefit' ? 'checked' : '' }}
                                   onchange="updateRadio()">
                            <div class="radio-icon" style="background: #ede9fe; color: #7c3aed;">
                                <i class="fas fa-arrow-trend-up"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 13px;">Benefit</div>
                                <div style="font-size: 11px; color: #6b7280;">Nilai lebih tinggi = lebih baik</div>
                            </div>
                        </label>

                        <label class="radio-card {{ old('tipe', $kriteria->tipe) === 'cost' ? 'selected' : '' }}"
                               id="labelCost">
                            <input type="radio" name="tipe" value="cost"
                                   {{ old('tipe', $kriteria->tipe) === 'cost' ? 'checked' : '' }}
                                   onchange="updateRadio()">
                            <div class="radio-icon" style="background: #fee2e2; color: #ef4444;">
                                <i class="fas fa-arrow-trend-down"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 13px;">Cost</div>
                                <div style="font-size: 11px; color: #6b7280;">Nilai lebih kecil = lebih baik</div>
                            </div>
                        </label>
                    </div>
                    @error('tipe') <div class="invalid-feedback" style="display:block; margin-top:6px;">{{ $message }}</div> @enderror
                </div>

                {{-- Bobot --}}
                <div class="form-group">
                    <label class="form-label">Bobot (W) <span class="required">*</span></label>
                    <input type="number" name="bobot" min="1" max="10"
                           class="form-control {{ $errors->has('bobot') ? 'is-invalid' : '' }}"
                           value="{{ old('bobot', $kriteria->bobot) }}" required>
                    <div class="form-hint">Bobot menentukan tingkat kepentingan kriteria. Total semua bobot = 15 (sesuai SRS).</div>
                    @error('bobot') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Status Kriteria</label>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 10px 14px;
                                  background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; margin-top: 4px;">
                        <input type="checkbox" name="aktif" value="1"
                               {{ old('aktif', $kriteria->aktif) ? 'checked' : '' }}
                               style="width: 16px; height: 16px; accent-color: #7c3aed; cursor: pointer;">
                        <div>
                            <div style="font-size: 13px; font-weight: 500; color: #1f2937;">Aktif</div>
                            <div style="font-size: 11px; color: #6b7280;">Kriteria nonaktif tidak dihitung dalam SAW</div>
                        </div>
                    </label>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">
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
    .form-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;
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
    .form-hint { font-size: 11.5px; color: #9ca3af; margin-top: 4px; }

    /* Radio card */
    .radio-card {
        flex: 1; display: flex; align-items: center; gap: 10px;
        padding: 12px; border: 2px solid #e5e7eb; border-radius: 10px;
        cursor: pointer; transition: border-color 0.2s, background 0.2s;
    }
    .radio-card input[type=radio] { display: none; }
    .radio-card.selected { border-color: #7c3aed; background: #faf5ff; }
    .radio-icon {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    function updateRadio() {
        document.getElementById('labelBenefit').classList.toggle(
            'selected', document.querySelector('input[value="benefit"]').checked
        );
        document.getElementById('labelCost').classList.toggle(
            'selected', document.querySelector('input[value="cost"]').checked
        );
    }
</script>
@endpush
