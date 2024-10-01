<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmed;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    // Handles POST request to filter available rooms
    public function filterAvailableRooms(Request $request)
    {
        $validated = $request->validate([
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'guest_count' => 'required|integer|min:1',
        ]);

        // Store the form data in the session
        Session::put('reservation_data', $validated);

        // Redirect to the GET route for showing available rooms
        return redirect()->route('rooms.show');
    }

    // Handles GET request to display available rooms (fetches data from session)
    public function availableRooms()
    {
        $reservationData = Session::get('reservation_data');

        if (!$reservationData) {
            return redirect()->route('home'); // Redirect to home if there's no reservation data
        }

        // Calculate total nights
        $checkin = Carbon::parse($reservationData['checkin_date']);
        $checkout = Carbon::parse($reservationData['checkout_date']);
        $total_nights = $checkin->diffInDays($checkout);

        // Fetch available rooms
        $availableRooms = Room::whereDoesntHave('reservations', function ($query) use ($reservationData) {
            $query->whereBetween('start_date', [$reservationData['checkin_date'], $reservationData['checkout_date']])
                ->orWhereBetween('end_date', [$reservationData['checkin_date'], $reservationData['checkout_date']]);
        })->where('capacity', '>=', $reservationData['guest_count'])->get();

        // Pass the data to the Inertia page
        return inertia('Guest/AvailableRooms', [
            'rooms' => $availableRooms,
            'checkin_date' => $reservationData['checkin_date'],
            'checkout_date' => $reservationData['checkout_date'],
            'guest_count' => $reservationData['guest_count'],
            'total_nights' => $total_nights,
        ]);
    }

    // Handles POST request to initiate the checkout process
    public function checkout(Request $request)
    {
        $room = Room::findOrFail($request->room_id);

        // Store room and reservation details in the session
        Session::put('checkout_data', [
            'room' => $room,
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'guest_count' => $request->guest_count,
            'total_nights' => $request->total_nights
        ]);

        // Redirect to the GET route for showing the checkout page
        return redirect()->route('checkout.show', ['room' => $room->id]);
    }

    // Handles GET request to display the checkout page (fetches data from session)
    public function showCheckout(Room $room)
    {
        $checkoutData = Session::get('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('home'); // Redirect to home if there's no checkout data
        }

        return inertia('Guest/Checkout', [
            'room' => $checkoutData['room'],
            'checkin_date' => $checkoutData['checkin_date'],
            'checkout_date' => $checkoutData['checkout_date'],
            'guest_count' => $checkoutData['guest_count'],
            'total_nights' => $checkoutData['total_nights'],
        ]);
    }

    public function confirm(Request $request)
    {
        // Validate the guest details and reservation info
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'guest_count' => 'required|integer|min:1',
            'number_of_rooms' => 'required|integer|min:1',
        ]);

        // Find or create the guest based on their email
        $guest = Guest::firstOrCreate(
            ['email' => $validated['guest_email']],
            [
                'name' => $validated['guest_name'],
                'phone_number' => $validated['guest_phone']
            ]
        );

        // Generate the reference number: YYMMDD + 5 random characters
        $checkinDate = Carbon::parse($validated['start_date'])->format('ymd'); // Convert check-in date to YYMMDD
        $randomString = strtoupper(Str::random(5)); // Generate 5 random characters
        $referenceNumber = $checkinDate . $randomString; // Combine both to form the reference number

        // Create the reservation with the guest linked
        $reservation = Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $validated['room_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'number_of_rooms' => $validated['number_of_rooms'],
            'status' => 'pending',
            'number_of_guests' => $validated['guest_count'],
            'reference_number' => $referenceNumber,
        ]);

        // Store the reservation ID in the session and redirect to the payment page
        Session::put('reservation_id', $reservation->id);

        return redirect()->route('payment.show');
    }

    // Show the payment page (fake card payment)
    public function showPaymentPage()
    {
        $reservationId = Session::get('reservation_id');

        if (!$reservationId) {
            return redirect()->route('home'); // Redirect if no reservation is found in the session
        }

        return inertia('Guest/Payment', [
            'fakeCard' => [
                'card_number' => '4242 4242 4242 4242',
                'expiry' => '12/24',
                'cvv' => '123'
            ]
        ]);
    }

    // Process the fake payment and update reservation status
    public function processPayment(Request $request)
    {
        $reservationId = Session::get('reservation_id');

        if (!$reservationId) {
            return redirect()->route('home'); // Redirect if no reservation is found in the session
        }

        // Mark the reservation as completed
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->update(['status' => 'booked']);

        // Clear the session
        Session::forget('reservation_id');

        Mail::to($reservation->guest->email)->queue(new BookingConfirmed($reservation, $reservation->guest));

        // Redirect to the success page with the reservation details
        return redirect()->route('reservation.success', ['reservation' => $reservationId]);
    }

    public function showSuccessPage(Reservation $reservation)
    {
        return inertia('Guest/ReservationSuccess', [
            'reservation' => $reservation->load('room', 'guest') // Load related room and guest details
        ]);
    }

    public function cancelReservation(Reservation $reservation)
    {
        // Update reservation status to 'canceled'
        $reservation->update(['status' => 'canceled']);

        // Redirect to home with a message
        return redirect()->route('home')->with('message', 'Your reservation has been canceled.');
    }

    // Handles payment cancellation (before it's completed)
    public function cancelPayment(Request $request)
    {
        $reservationId = Session::get('reservation_id');

        if (!$reservationId) {
            return redirect()->route('home'); // Redirect if no reservation is found
        }

        // Find the reservation and mark it as canceled
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->update(['status' => 'canceled']);

        // Clear the session and redirect to home with a message
        Session::forget('reservation_id');
        return redirect()->route('home')->with('message', 'The payment has been canceled and your reservation is canceled.');
    }
}
