<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'location',
        'last_maintenance_date',
        'next_maintenance_date',
        'purchase_date',
        'warranty_expiry_date',
        'serial_number',
        'model_number',
        'manufacturer',
        'category',
        'condition',
        'notes'
    ];

    protected $casts = [
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'purchase_date' => 'date',
        'warranty_expiry_date' => 'date',
    ];

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
} 