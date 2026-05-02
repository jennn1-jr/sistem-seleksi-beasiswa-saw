<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pendaftar extends Model
{
    protected $table = 'pendaftar';

    protected $fillable = [
        'nim',
        'nama',
        'program_studi',
        'semester',
        'email',
        'no_hp',
        // Nilai mentah kriteria
        'ipk',
        'penghasilan_ortu',
        'semester_aktif',
        'jml_tanggungan',
        'keikutsertaan_organisasi',
        // Status verifikasi
        'status_verifikasi',
        'catatan_verifikasi',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'ipk'                      => 'decimal:2',
        'penghasilan_ortu'         => 'decimal:2',
        'verified_at'              => 'datetime',
    ];

    // ── Relasi ────────────────────────────────────────────
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function hasilSaw(): HasOne
    {
        return $this->hasOne(HasilSaw::class, 'pendaftar_id');
    }

    // ── Helpers ───────────────────────────────────────────
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'terverifikasi';
    }

    public function isDitolak(): bool
    {
        return $this->status_verifikasi === 'ditolak';
    }

    // Cek apakah semua nilai kriteria sudah terisi
    public function nilaiLengkap(): bool
    {
        return ! is_null($this->ipk)
            && ! is_null($this->penghasilan_ortu)
            && ! is_null($this->semester_aktif)
            && ! is_null($this->jml_tanggungan)
            && ! is_null($this->keikutsertaan_organisasi);
    }

    // Ambil nilai mentah sebagai array per kriteria
    public function nilaiMentahArray(): array
    {
        return [
            'C1' => (float) $this->ipk,
            'C2' => (float) $this->penghasilan_ortu,
            'C3' => (float) $this->semester_aktif,
            'C4' => (float) $this->jml_tanggungan,
            'C5' => (float) $this->keikutsertaan_organisasi,
        ];
    }
}