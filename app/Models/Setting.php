<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'logo',
        'email',
        'phone',
        'address',
        'maintenance_mode',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}