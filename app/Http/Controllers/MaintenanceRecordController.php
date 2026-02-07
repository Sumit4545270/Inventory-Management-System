<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\Equipment;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function index()
    {
        $maintenanceRecords = MaintenanceRecord::with('equipment')->latest()->get();
        return view('maintenance-records.index', compact('maintenanceRecords'));
    }

    public function create()
    {
        $equipment = Equipment::all();
        return view('maintenance-records.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'maintenance_date' => 'required|date',
            'maintenance_type' => 'required|string',
            'description' => 'required|string',
            'technician' => 'required|string',
            'cost' => 'required|numeric',
            'status' => 'required|string',
            'next_maintenance_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $maintenanceRecord = MaintenanceRecord::create($validated);

        // Update equipment's last maintenance date and next maintenance date
        $equipment = Equipment::find($validated['equipment_id']);
        $equipment->update([
            'last_maintenance_date' => $validated['maintenance_date'],
            'next_maintenance_date' => $validated['next_maintenance_date'],
        ]);

        return redirect()->route('maintenance-records.index')
            ->with('success', 'Maintenance record created successfully.');
    }

    public function show(MaintenanceRecord $maintenanceRecord)
    {
        return view('maintenance-records.show', compact('maintenanceRecord'));
    }

    public function edit(MaintenanceRecord $maintenanceRecord)
    {
        $equipment = Equipment::all();
        return view('maintenance-records.edit', compact('maintenanceRecord', 'equipment'));
    }

    public function update(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'maintenance_date' => 'required|date',
            'maintenance_type' => 'required|string',
            'description' => 'required|string',
            'technician' => 'required|string',
            'cost' => 'required|numeric',
            'status' => 'required|string',
            'next_maintenance_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $maintenanceRecord->update($validated);

        // Update equipment's last maintenance date and next maintenance date
        $equipment = Equipment::find($validated['equipment_id']);
        $equipment->update([
            'last_maintenance_date' => $validated['maintenance_date'],
            'next_maintenance_date' => $validated['next_maintenance_date'],
        ]);

        return redirect()->route('maintenance-records.index')
            ->with('success', 'Maintenance record updated successfully.');
    }

    public function destroy(MaintenanceRecord $maintenanceRecord)
    {
        $maintenanceRecord->delete();

        return redirect()->route('maintenance-records.index')
            ->with('success', 'Maintenance record deleted successfully.');
    }
} 