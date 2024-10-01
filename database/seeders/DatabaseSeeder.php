<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Room::factory(10)->create();

        $this->call([
           UserSeeder::class,
            DeveloperPopulateDatabaseSeeder::class
        ]);

    }
}
