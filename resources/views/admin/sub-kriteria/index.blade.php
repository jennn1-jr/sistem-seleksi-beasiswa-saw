@extends('layouts.admin')

@section('title', 'Kelola Sub Kriteria')
@section('page-title', 'Kelola Sub Kriteria')
@section('breadcrumb', 'Atur rentang nilai dan skor konversi tiap kriteria (SRS: FR-05)')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Sub Kriteria</h1>
        <p>Rentang nilai yang mengonversi data mentah mahasiswa menjadi skor untuk perhitungan SAW.</p>
    </div>
</div>

{{-- ── Satu card per Kriteria ───────────────────────────── --}}
@foreach($kriteria as $k)
<div class="card" style="margin-bottom: 20px;">

    {{-- Header Kriteria --}}
    <div class="card-header">
        <div class="card-title">
            <span style="display:inline-flex; align-items:center; justify-content:center;
                         width:32px; height:32px; border-radius:8px; font-size:11px;
                         font-weight:700; color:#fff;
                         background: {{ $k->isBenefit() ? '#7c3aed' : '#ef4444' }};">
                {{ $k->kode }}
            </span>
            {{ $k->nama }}
            @if($k->isBenefit())
                <span class="badge badge-purple" style="font-size:10px;">Benefit</span>
            @else
                <span class="badge badge-danger" style="font-size:10px;">Cost</span>
            @endif
        </div>
        <div style="font-size: 12px; color: var(--text-muted);">Bobot: <strong>{{ $k->bobot }}</strong></div>
    </div>

    {{-- Tabel Sub Kriteria --}}
    <div class="table-wrapper">
        @if($k->subKriteria->isEmpty())
            <div style="padding: 32px; text-align: center; color: var(--text-muted); font-size: 13px;">
                <i class="fas fa-inbox" style="font-size: 28px; display: block; margin-bottom: 8px; opacity: 0.4;"></i>
                Belum ada sub kriteria untuk {{ $k->kode }}.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Label / Keterangan</th>
                        <th style="text-align:center;">Nilai Min</th>
                        <th style="text-align:center;">Nilai Max</th>
                        <th style="text-align:center;">Skor</th>
                        <th style="text-align:center; width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($k->subKriteria->sortBy('nilai_min') as $i => $sub)
                    <tr>
                        <td style="color: var(--text-muted); font-size:12px;">{{ $i + 1 }}</td>
                        <td style="font-size:13.5px; color: var(--text);">{{ $sub->label ?? '-' }}</td>
                        <td style="text-align:center; font-size:13px;">
                            @if($k->kode === 'C2')
                                Rp {{ number_format($sub->nilai_min, 0, ',', '.') }}
                            @else
                                {{ number_format($sub->nilai_min, 2) }}
                            @endif
                        </td>
                        <td style="text-align:center; font-size:13px;">
                            @if($k->kode === 'C2')
                                Rp {{ number_format($sub->nilai_max, 0, ',', '.') }}
                            @else
                                {{ number_format($sub->nilai_max, 2) }}
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span style="font-size:18px; font-weight:800; color:#7c3aed;">{{ (int)$sub->skor }}</span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; gap:4px; justify-content:center;">
                                {{-- Tombol Edit (modal inline) --}}
                                <button type="button" class="btn btn-secondary btn-sm btn-icon"
                                        onclick="openEditModal({{ $sub->id }}, '{{ addslashes($sub->label) }}', {{ $sub->nilai_min }}, {{ $sub->nilai_max }}, {{ $sub->skor }})"
                                        title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                {{-- Tombol Hapus --}}
                                <form method="POST" action="{{ route('admin.sub-kriteria.destroy', $sub->id) }}"
                                      onsubmit="return confirm('Hapus sub kriteria ini?')">
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
        @endif
    </div>

    {{-- Form Tambah Sub Kriteria (inline) --}}
    <div class="subk-form-bar">
        <form method="POST" action="{{ route('admin.sub-kriteria.store') }}"
              style="display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap;">
            @csrf
            <input type="hidden" name="kriteria_id" value="{{ $k->id }}">

            <div style="flex: 2; min-width: 120px;">
                <label class="subk-label">Label</label>
                <input type="text" name="label" placeholder="Contoh: IPK Sangat Baik"
                       class="form-control-sm">
            </div>
            <div style="flex: 1; min-width: 90px;">
                <label class="subk-label">Nilai Min</label>
                <input type="number" name="nilai_min" step="any" required placeholder="0"
                       class="form-control-sm">
            </div>
            <div style="flex: 1; min-width: 90px;">
                <label class="subk-label">Nilai Max</label>
                <input type="number" name="nilai_max" step="any" required placeholder="100"
                       class="form-control-sm">
            </div>
            <div style="flex: 1; min-width: 70px;">
                <label class="subk-label">Skor</label>
                <input type="number" name="skor" step="any" required placeholder="75"
                       class="form-control-sm">
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
        </form>
    </div>

</div>
@endforeach

{{-- ── Modal Edit Sub Kriteria ─────────────────────────── --}}
<div id="editModal" class="edit-modal-overlay">
    <div class="edit-modal-box">
        <h3 class="edit-modal-title">
            <i class="fas fa-pen" style="color:#7c3aed;"></i> Edit Sub Kriteria
        </h3>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                <div style="grid-column:1/-1;">
                    <label class="form-label-sm">Label</label>
                    <input type="text" name="label" id="editLabel" class="form-control">
                </div>
                <div>
                    <label class="form-label-sm">Nilai Min</label>
                    <input type="number" name="nilai_min" id="editMin" step="any" required class="form-control">
                </div>
                <div>
                    <label class="form-label-sm">Nilai Max</label>
                    <input type="number" name="nilai_max" id="editMax" step="any" required class="form-control">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label-sm">Skor Konversi</label>
                    <input type="number" name="skor" id="editSkor" step="any" required class="form-control">
                </div>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:20px;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* ── Form bar bawah tiap card ── */
    .subk-form-bar {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        background: var(--bg);
    }

    /* Label form tambah */
    .subk-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
        margin-bottom: 4px;
    }

    /* Input kecil */
    .form-control-sm {
        width: 100%;
        padding: 7px 10px;
        border: 1px solid var(--border);
        border-radius: 7px;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        background: var(--surface);
        color: var(--text);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control-sm::placeholder { color: var(--text-muted); opacity: 0.6; }
    .form-control-sm:focus { border-color: #7c3aed; box-shadow: 0 0 0 2px rgba(124,58,237,0.15); }

    /* Input modal */
    .form-control {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13.5px;
        font-family: inherit;
        outline: none;
        background: var(--surface);
        color: var(--text);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control::placeholder { color: var(--text-muted); opacity: 0.6; }
    .form-control:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.15); }

    /* Label modal */
    .form-label    { font-size: 13px;   font-weight: 500; color: var(--text-muted); margin-bottom: 6px;  display: block; }
    .form-label-sm { font-size: 12px;   font-weight: 500; color: var(--text-muted); margin-bottom: 4px;  display: block; }

    /* Modal overlay & box */
    .edit-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .edit-modal-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        width: 100%;
        max-width: 440px;
        margin: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .edit-modal-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text);
    }
</style>
@endpush

@push('scripts')
<script>
    const editModal = document.getElementById('editModal');

    function openEditModal(id, label, min, max, skor) {
        const baseUrl = "{{ url('admin/sub-kriteria') }}";
        document.getElementById('editForm').action = baseUrl + '/' + id;
        document.getElementById('editLabel').value = label;
        document.getElementById('editMin').value   = min;
        document.getElementById('editMax').value   = max;
        document.getElementById('editSkor').value  = skor;
        editModal.style.display = 'flex';
    }

    function closeEditModal() {
        editModal.style.display = 'none';
    }

    // Tutup modal jika klik di luar
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) closeEditModal();
    });
</script>
@endpush
