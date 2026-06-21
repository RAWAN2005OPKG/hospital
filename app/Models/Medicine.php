<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'description',
        'image',
        'stock',
        'quantity',
        'reserved_quantity',
        'available_quantity',
        'low_stock_threshold',
        'price',
        'production_date',
        'expiration_date',
        'manufacturer',
        'batch_number',
        'is_active',
        'availability_status',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'production_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicines')
                    ->withPivot('dosage', 'days', 'notes')
                    ->withTimestamps();
    }

    public function isLowStock()
    {
        return $this->stock <= $this->low_stock_threshold;
    }

    public function isExpiringSoon($days = 30)
    {
        return $this->expiration_date && 
               $this->expiration_date <= now()->addDays($days) && 
               $this->expiration_date >= now();
    }

    public function isExpired()
    {
        return $this->expiration_date && $this->expiration_date < now();
    }

    public function isAvailable()
    {
        return $this->is_active && 
               $this->stock > 0 && 
               !$this->isExpired();
    }

    public function getAvailableQuantity()
    {
        return max(0, $this->stock - ($this->reserved_quantity ?? 0));
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', true)
                     ->where('stock', '>', 0)
                     ->where(function ($q) {
                         $q->whereNull('expiration_date')
                           ->orWhere('expiration_date', '>', now());
                     });
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'low_stock_threshold')
                     ->where('is_active', true);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiration_date', '<=', now()->addDays($days))
                     ->where('expiration_date', '>=', now())
                     ->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiration_date', '<', now());
    }
}
