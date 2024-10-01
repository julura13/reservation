<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $rooms = Room::factory(10)->create();

//        Guest::factory(20)->create()->each(function ($guest) use ($rooms) {
//            Reservation::factory()->create([
//                'guest_id' => $guest->id,
//                'room_id' => $rooms->random()->id,
//            ]);
//        });
    }
}
