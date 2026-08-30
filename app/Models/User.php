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
            'panitia' => 'panitia',
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

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        if (count($words) >= 2) {
            // Mengambil Huruf Pertama 
            $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
        } else {
            $initials = strtoupper(substr($this->name, 0, 2));
        }
        return $initials;
    }
    public function getAvatarColorAttribute(): string
    {
        // Warna untuk Profil jika belum menambahkan foto
        $colors = [
            '#FF6B6B', 
            '#4ECDC4', 
            '#45B7D1', 
            '#96CEB4', 
            '#FFEAA7', 
            '#DDA0DD', 
            '#FF8A5C', 
            '#A29BFE', 
            '#FD79A8', 
            '#00B894', 
            '#E17055', 
            '#74B9FF', 
            '#FDCB6E', 
            '#6C5CE7', 
            '#00CEC9', 
            '#FF7675', 
            '#FDCB6E', 
            '#A3CB38', 
            '#FDA7DF', 
            '#7EFFDC', 
            '#F97F51', 
            '#B33771', 
            '#3B3B98', 
            '#FC427B', 
            '#BDC581', 
            '#82589F', 
            '#F8A5C2', 
            '#63CDDA', 
            '#3DC1D3', 
            '#E15F41', 
            '#C44569', 
            '#574B90', 
            '#F19066', 
            '#E8A87C', 
            '#85CDCA', 
            '#CF6A87', 
            '#786FA6', 
            '#F3A683', 
            '#63B7AF', 
            '#E77F67', 
        ];

        $index = abs(crc32($this->name)) % count($colors);
        return $colors[$index];
    }

    public function getInitialAvatarUrl(): string
    {
        $initials = $this->initials;
        $color = ltrim($this->avatar_color, '#');
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) . 
               "&size=200&background=" . $color . 
               "&color=ffffff&bold=true&font-size=0.5&length=2";
    }

    public function juri()
    {
        return $this->hasOne(Juri::class, 'user_id', 'id');
    }

    public function isJuri(): bool
    {
        return $this->juri()->exists();
    }
}
