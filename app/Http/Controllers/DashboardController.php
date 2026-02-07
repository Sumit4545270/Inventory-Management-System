<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRecord;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEquipment = Equipment::count();
        $totalMaintenanceRecords = MaintenanceRecord::count();
        $totalReservations = Reservation::count();
        
        $recentMaintenanceRecords = MaintenanceRecord::with('equipment')
            ->latest()
            ->take(5)
            ->get();
            
        $upcomingMaintenance = Equipment::where('next_maintenance_date', '<=', now()->addDays(30))
            ->get();
            
        $recentReservations = Reservation::with('equipment')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEquipment',
            'totalMaintenanceRecords',
            'totalReservations',
            'recentMaintenanceRecords',
            'upcomingMaintenance',
            'recentReservations'
        ));
    }
} 