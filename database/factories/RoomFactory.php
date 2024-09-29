<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Single Room', 'Deluxe Suite', 'Family Room']),
            'capacity' => $this->faker->numberBetween(1, 4),
            'price_per_night' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
