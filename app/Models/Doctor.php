<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'license_number',
        'experience_years',
        'bio',
        'availability_status',
        'consultation_fee',
        'department_id',
    ];

    protected $casts = [
        'availability_status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // Alias for legacy/typo usage in some controllers (e.g. with('specialization'))
    public function specialization()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'receiver_id')->whereHas('sender', function ($query) {
            $query->where('role', \App\Enums\UserRoleEnum::Patient);
        });
    }
}