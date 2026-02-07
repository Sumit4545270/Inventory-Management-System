<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Equipment routes
    Route::resource('equipment', EquipmentController::class);
    
    // Maintenance Record routes
    Route::resource('maintenance-records', MaintenanceRecordController::class);
    
    // Reservation routes
    Route::resource('reservations', ReservationController::class);
});

require __DIR__.'/auth.php'; 