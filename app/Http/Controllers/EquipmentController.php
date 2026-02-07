<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();
        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        return view('equipment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'purchase_date' => 'nullable|date',
            'warranty_expiry_date' => 'nullable|date',
            'serial_number' => 'nullable|string',
            'model_number' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'category' => 'nullable|string',
            'condition' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment created successfully.');
    }

    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'location' => 'required|string',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'purchase_date' => 'nullable|date',
            'warranty_expiry_date' => 'nullable|date',
            'serial_number' => 'nullable|string',
            'model_number' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'category' => 'nullable|string',
            'condition' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment updated successfully.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment deleted successfully.');
    }
} 