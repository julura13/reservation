<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);

        // Fetch completed reservations in the upcoming week
        $completedReservations = Reservation::where('status', 'booked')
            ->whereBetween('start_date', [$today, $nextWeek])
            ->with('guest', 'room')
            ->get();

        $totalReservations = $completedReservations->count();
        $totalGuests = $completedReservations->sum('number_of_guests');
        $totalRooms = $completedReservations->sum('number_of_rooms');

        return inertia('Admin/Dashboard', [
            'reservations' => $completedReservations,
            'totalReservations' => $totalReservations,
            'totalGuests' => $totalGuests,
            'totalRooms' => $totalRooms
        ]);
    }

    public function reservations(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $reservations = Reservation::with('guest', 'room')
            ->when($search, function ($query, $search) {
                return $query->whereHas('guest', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('room', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('start_date', 'asc')
            ->get();

        return inertia('Admin/Reservations', [
            'reservations' => $reservations
        ]);
    }

    public function markAsDone($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = 'done';
        $reservation->save();

        return response()->json(['message' => 'Reservation marked as done.']);
    }

    public function markAsCheckedIn($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = 'checked_in';
        $reservation->save();

        return response()->json(['message' => 'Reservation marked as checked in.']);
    }

}
