<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKriteria extends Model
{
    protected $table = 'sub_kriteria';

    protected $fillable = [
        'kriteria_id',
        'label',
        'nilai_min',
        'nilai_max',
        'skor',
    ];

    protected $casts = [
        'nilai_min' => 'decimal:2',
        'nilai_max' => 'decimal:2',
        'skor'      => 'decimal:2',
    ];

    // ── Relasi ke kriteria ────────────────────────────────
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    // ── Konversi nilai mentah ke skor ─────────────────────
    public static function konversiNilai(int $kriteriaId, float $nilaiMentah): ?float
    {
        $sub = self::where('kriteria_id', $kriteriaId)
            ->where('nilai_min', '<=', $nilaiMentah)
            ->where('nilai_max', '>=', $nilaiMentah)
            ->first();

        return $sub ? (float) $sub->skor : null;
    }
}