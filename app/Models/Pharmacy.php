<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pharmacists()
    {
        return $this->hasMany(Pharmacist::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
