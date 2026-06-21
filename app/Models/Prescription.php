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

    // Status options: pending, preparing, ready, delivered, cancelled

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

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function canBeDispensed()
    {
        if ($this->status !== 'pending' && $this->status !== 'preparing') {
            return false;
        }

        foreach ($this->medicines as $medicine) {
            if ($medicine->stock <= 0) {
                return false;
            }
        }

        return true;
    }
}