<?php

namespace App\Mail;

use App\Models\Guest;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $guest;

    /**
     * Create a new message instance.
     *
     * @param Reservation $reservation
     * @param Guest $guest
     */
    public function __construct(    Reservation $reservation, Guest $guest)
    {
        $this->reservation = $reservation;
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking-confirmed')
            ->subject('Your Booking is Confirmed!')
            ->with([
                'reservation' => $this->reservation,
                'guest' => $this->guest,
            ]);
    }

}
