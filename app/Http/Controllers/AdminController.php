<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);

        // Fetch completed reservations in the upcoming week
        $completedReservations = Reservation::where('status', 'booked')
            ->whereBetween('start_date', [$today, $nextWeek])
            ->with('guest', 'room')
            ->get();

        // Calculate totals
        $totalReservations = $completedReservations->count();
        $totalGuests = $completedReservations->sum('number_of_rooms'); // Adjust this based on your logic

        // Pass the data to Inertia for the Dashboard view
        return inertia('Admin/Dashboard', [
            'reservations' => $completedReservations,
            'totalReservations' => $totalReservations,
            'totalGuests' => $totalGuests,
        ]);
    }


    // Reservations Management Page with Search and Status Filter
    public function reservations(Request $request)
    {
        // Example to retrieve reservations and pass to frontend
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        // Fetch reservations with optional search and status filter
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

    // Upcoming Reservations (next 7 days)
    public function upcomingReservations()
    {
        $today = Carbon::today();
        $nextWeek = Carbon::today()->addDays(7);

        $upcomingReservations = Reservation::whereBetween('start_date', [$today, $nextWeek])
            ->with('guest', 'room')
            ->get();

        return inertia('Admin/UpcomingReservations', ['reservations' => $upcomingReservations]);
    }

    public function markAsDone($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId); // Ensure the reservation exists
        $reservation->status = 'done'; // Update the status to 'done'
        $reservation->save(); // Save the changes

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
