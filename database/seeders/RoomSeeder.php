<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\RoomType;
use Faker\Core\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Room::truncate();
        for ($floor = 1; $floor <= 5; $floor++) {
            for ($room = 1; $room <= 10; $room++) {
                $roomNumber = $floor . ($room == 10 ? '': '0') . $room;

                Room::factory()->state(function () use ($roomNumber) {
                    return ['number' => $roomNumber];
                })->create();
            }
        }
    }
}
