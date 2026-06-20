<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserRoleEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'avatar',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRoleEnum::class, // Cast to Enum
    ];

    // Relationships
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Accessors
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name ) . '&color=0066cc&background=e0f2f7';
    }

    // Role Checks
    public function isAdmin()
    {
        return $this->role === UserRoleEnum::Admin;
    }

    public function isReceptionist()
    {
        return $this->role === UserRoleEnum::Receptionist;
    }

    public function isStaff(): bool
    {
        return $this->role instanceof UserRoleEnum && $this->role->isStaff();
    }

    public function isDoctor()
    {
        return $this->role === UserRoleEnum::Doctor;
    }

    public function isPatient()
    {
        return $this->role === UserRoleEnum::Patient;
    }

    public function isPharmacist()
    {
        return $this->role === UserRoleEnum::Pharmacist;
    }
}