<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'maintenance_date',
        'maintenance_type',
        'description',
        'technician',
        'cost',
        'status',
        'next_maintenance_date',
        'notes'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
} 