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
        'role_id',
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

    // ✅ relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ✅ helper role
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isTeller(): bool
    {
        return $this->role && $this->role->name === 'teller';
    }

    public function isNasabah(): bool
    {
        return $this->role && $this->role->name === 'nasabah';
    }
}
