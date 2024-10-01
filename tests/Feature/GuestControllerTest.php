<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it shows the reservation form', function () {
    $this->get('/reservations')
        ->assertOk()
        ->assertStatus(200)
        ->assertSeeHtml('Reservation Form'); // Assuming this text exists on the form page
});

test('it searches available rooms', function () {
    // Create some rooms
    $room1 = Room::factory()->create(['capacity' => 2]);
    $room2 = Room::factory()->create(['capacity' => 4]);

    dump($room1);

    // Create a reservation that blocks room1
    Reservation::factory()->create([
        'room_id' => $room1->id,
        'start_date' => now()->addDays(2),
        'end_date' => now()->addDays(5),
    ]);

    // Send request to search rooms in a conflicting date range
    $response = $this->postJson(route('guest.reservations.search'), [
        'start_date' => now()->addDays(1)->format('Y-m-d'),
        'end_date' => now()->addDays(3)->format('Y-m-d'),
        'guest_count' => 2,
    ]);

    dump($response->json());

    $response->assertStatus(200)
        ->assertJsonMissing(['id' => $room1->id]) // Room 1 should not be available
        ->assertJsonFragment(['id' => $room2->id]); // Room 2 should be available
});

test('it stores a new reservation', function () {
    // Create a room
    $room = Room::factory()->create();

    // Make a reservation
    $response = $this->post(route('guest.reservations.store'), [
        'guest_name' => 'John Doe',
        'guest_email' => 'john@example.com',
        'guest_phone' => '123456789',
        'room_id' => $room->id,
        'start_date' => now()->addDays(2)->format('Y-m-d'),
        'end_date' => now()->addDays(5)->format('Y-m-d'),
        'number_of_rooms' => 1,
    ]);

    $response->assertRedirect(route('guest.reservations.success'));

    // Check that the guest and reservation were created
    $this->assertDatabaseHas('guests', ['email' => 'john@example.com']);
    $this->assertDatabaseHas('reservations', ['room_id' => $room->id]);
});

