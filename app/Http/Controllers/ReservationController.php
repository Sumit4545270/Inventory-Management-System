<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Equipment;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('equipment')->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $equipment = Equipment::where('status', 'available')->get();
        return view('reservations.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Check if equipment is available for the requested time period
        $conflictingReservation = Reservation::where('equipment_id', $validated['equipment_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflictingReservation) {
            return back()->withErrors(['time' => 'The equipment is already reserved for this time period.']);
        }

        $reservation = Reservation::create($validated);

        // Update equipment status if needed
        if ($validated['status'] === 'approved') {
            $equipment = Equipment::find($validated['equipment_id']);
            $equipment->update(['status' => 'in_use']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $equipment = Equipment::where('status', 'available')->get();
        return view('reservations.edit', compact('reservation', 'equipment'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'user_id' => 'required|exists:users,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Check for conflicts excluding the current reservation
        $conflictingReservation = Reservation::where('equipment_id', $validated['equipment_id'])
            ->where('id', '!=', $reservation->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflictingReservation) {
            return back()->withErrors(['time' => 'The equipment is already reserved for this time period.']);
        }

        $oldStatus = $reservation->status;
        $reservation->update($validated);

        // Update equipment status if needed
        if ($oldStatus !== $validated['status']) {
            $equipment = Equipment::find($validated['equipment_id']);
            $equipment->update([
                'status' => $validated['status'] === 'approved' ? 'in_use' : 'available'
            ]);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $equipment = $reservation->equipment;
        $reservation->delete();

        // Update equipment status if needed
        if ($reservation->status === 'approved') {
            $equipment->update(['status' => 'available']);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
} 