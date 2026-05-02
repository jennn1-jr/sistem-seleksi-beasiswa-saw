<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $table = 'pengaturan_sistem';

    protected $fillable = ['kunci', 'nilai', 'keterangan'];

    // ── Static helper: ambil nilai setting ───────────────
    public static function get(string $kunci, mixed $default = null): mixed
    {
        $row = self::where('kunci', $kunci)->first();
        return $row ? $row->nilai : $default;
    }

    // ── Static helper: set nilai setting ─────────────────
    public static function set(string $kunci, mixed $nilai, string $keterangan = ''): void
    {
        self::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'keterangan' => $keterangan]
        );
    }
}
