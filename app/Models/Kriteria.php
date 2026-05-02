<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'bobot',
        'aktif',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    // ── Relasi ke sub kriteria ────────────────────────────
    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }

    // ── Helper: apakah tipe benefit ──────────────────────
    public function isBenefit(): bool
    {
        return $this->tipe === 'benefit';
    }

    public function isCost(): bool
    {
        return $this->tipe === 'cost';
    }
}