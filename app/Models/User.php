<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active', // 🔥 NUEVO CAMPO
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
            'is_active' => 'boolean', // 🔥 CAST A BOOLEAN
        ];
    }

    // 🔥 SCOPE PARA USUARIOS ACTIVOS
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 🔥 SCOPE PARA USUARIOS INACTIVOS
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}