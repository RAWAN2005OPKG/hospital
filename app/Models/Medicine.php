<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock',
        'low_stock_threshold',
        'price',
        'is_active',
    ];

    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicines')
                    ->withPivot('dosage', 'days', 'notes')
                    ->withTimestamps();
    }
}
