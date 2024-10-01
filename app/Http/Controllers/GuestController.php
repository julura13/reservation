<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    // Show the reservation form and available rooms
    public function showReservationForm()
    {
        return inertia('Guest/ReservationForm');
    }

//    public function findAvailableRooms(Request $request)
//    {
//        $request->validate([
//            'checkin_date' => 'required|date',
//            'checkout_date' => 'required|date|after:checkin_date',
//            'guest_count' => 'required|integer|min:1',
//        ]);
//
//        // Find rooms that are not booked in the given date range
//        $availableRooms = Room::whereDoesntHave('reservations', function ($query) use ($request) {
//            $query->where(function($q) use ($request) {
//                $q->whereBetween('start_date', [$request->checkin_date, $request->checkout_date])
//                    ->orWhereBetween('end_date', [$request->checkin_date, $request->checkout_date]);
//            });
//        })->where('capacity', '>=', $request->guest_count)->get();
//
//        return inertia('Guest/AvailableRooms', ['rooms' => $availableRooms]);
//    }

    // Search available rooms based on date range and capacity
    public function searchRooms(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'guest_count' => 'required|integer|min:1',
        ]);

        // Find rooms that are not booked in the given date range
        $rooms = Room::whereDoesntHave('reservations', function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
        })->where('capacity', '>=', $request->guest_count)->get();

        return response()->json(['rooms' => $rooms]);
    }

    // Store a new reservation
    public function storeReservation(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'number_of_rooms' => 'required|integer|min:1',
        ]);

        // Create guest
        $guest = Guest::create([
            'name' => $request->guest_name,
            'email' => $request->guest_email,
            'phone_number' => $request->guest_phone,
        ]);

        // Create reservation
        Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $request->room_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'number_of_rooms' => $request->number_of_rooms,
        ]);

        return redirect()->route('guest.reservations.success');
    }
}

