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
}

