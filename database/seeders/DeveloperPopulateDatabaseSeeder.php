<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DeveloperPopulateDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate rooms to associate with reservations
        $rooms = Room::factory()->count(5)->create();

        // Today's date
        $today = Carbon::today();

        // 1. Guests with bookings starting today
        foreach (range(1, 3) as $i) {
            Reservation::factory()->create([
                'start_date' => $today,
                'end_date' => $today->copy()->addDays(rand(1, 5)),
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'booked',
                'reference_number' => $this->generateReferenceNumber($today)
            ]);
        }

        // 2. Guests with bookings ending today
        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->subDays(rand(1, 5));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $today,
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'booked',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        // 3. Guests with bookings in the next 7 days
        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->addDays(rand(1, 7));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $start_date->copy()->addDays(rand(1, 5)),
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'booked',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        // 4. Guests with future bookings (after 7 days)
        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->addDays(rand(8, 30));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $start_date->copy()->addDays(rand(1, 5)),
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'booked',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->addDays(rand(8, 30));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $start_date->copy()->addDays(rand(1, 5)),
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'pending',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->addDays(rand(8, 30));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $start_date->copy()->addDays(rand(1, 5)),
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'canceled',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->subDays(rand(1, 5));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $today,
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'done',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }

        foreach (range(1, 3) as $i) {
            $start_date = $today->copy()->subDays(rand(1, 5));
            Reservation::factory()->create([
                'start_date' => $start_date,
                'end_date' => $today,
                'number_of_guests' => rand(1, 4),
                'room_id' => $rooms->random()->id,
                'status' => 'checked_in',
                'reference_number' => $this->generateReferenceNumber($start_date)
            ]);
        }
    }

    function generateReferenceNumber($startDate)
    {
        // Generate the reference number: YYMMDD + 5 random characters
        $checkinDate = Carbon::parse($startDate)->format('ymd');
        $randomString = strtoupper(Str::random(5));
        return $referenceNumber = $checkinDate . $randomString;
    }
}
