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
        'phone',
        'password',
        'role',
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

    // التحقق من أنه admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // التحقق من أنه طبيب
    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    // التحقق من أنه مريض
    public function isPatient()
    {
        return $this->role === 'patient';
    }
}