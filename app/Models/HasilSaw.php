<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilSaw extends Model
{
    protected $table = 'hasil_saw';

    protected $fillable = [
        'pendaftar_id',
        'x_c1', 'x_c2', 'x_c3', 'x_c4', 'x_c5',
        'r_c1', 'r_c2', 'r_c3', 'r_c4', 'r_c5',
        'nilai_preferensi',
        'peringkat',
        'lolos',
        'periode',
        'dieksekusi_oleh',
        'dieksekusi_at',
    ];

    protected $casts = [
        'lolos'         => 'boolean',
        'dieksekusi_at' => 'datetime',
    ];

    // ── Relasi ────────────────────────────────────────────
    public function pendaftar(): BelongsTo
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    public function dieksekusiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dieksekusi_oleh');
    }
}