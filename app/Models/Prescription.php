<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medications',
        'dosage',
        'notes',
        'status',
    ];

    protected $casts = [
        'medications' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicines')
                    ->withPivot('dosage', 'days', 'notes')
                    ->withTimestamps();
    }
}