<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telp',
        'jabatan',
        'foto_profil',
        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isPanitia(): bool
    {
        return $this->role === 'panitia';
    }

    // untuk role
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'panitia' => 'Panitia',
            default => 'panitia'
        };
    }

    // untuk foto profil
    public function getFotoProfilUrlAttribute(): string
    {
        if ($this->foto_profil && file_exists(public_path('uploads/profil/' . $this->foto_profil))) {
            return asset('uploads/profil/' . $this->foto_profil);
        }
        return asset('img/default-avatar.png');
    }
}
