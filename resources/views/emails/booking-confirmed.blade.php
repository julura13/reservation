<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
</head>
<body>
<h1>Booking Confirmed!</h1>
<p>Dear {{ $guest->name }},</p>

<p>Your booking has been successfully confirmed. Below are your booking details:</p>

<ul>
    <li><strong>Reference Number:</strong> {{ $reservation->reference_number }}</li>
    <li><strong>Room:</strong> {{ $reservation->room->name }}</li>
    <li><strong>Check-in Date:</strong> {{ $reservation->start_date }}</li>
    <li><strong>Check-out Date:</strong> {{ $reservation->end_date }}</li>
    <li><strong>Number of Guests:</strong> {{ $reservation->number_of_guests }}</li>
</ul>

<p>Thank you for booking with us!</p>
</body>
</html>
