<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'guest_id' => Guest::factory(),
            'room_id' => Room::factory(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'number_of_rooms' => 1,
        ];
    }
}
