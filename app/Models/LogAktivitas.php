<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'tabel_terkait',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mencatat aktivitas admin (audit trail). Aman dipanggil hanya dari route bert middleware admin.
     */
    public static function catat(string $aktivitas, string $tabelTerkait): void
    {
        if (! Auth::check()) {
            return;
        }

        static::create([
            'user_id'        => Auth::id(),
            'aktivitas'      => $aktivitas,
            'tabel_terkait'  => $tabelTerkait,
        ]);
    }
}
