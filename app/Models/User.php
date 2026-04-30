<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'nim',
        'program_studi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ── Helper roles ──────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
}