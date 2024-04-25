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
        $freeStatusId = RoomStatus::where('status', 'Vacant')->first()->id;

        Room::truncate();
        for ($floor = 1; $floor <= 5; $floor++) {
            for ($room = 1; $room <= 10; $room++) {
                $roomNumber = $floor . ($room == 10 ? '': '0') . $room;

                Room::create([
                    'number' => $roomNumber,
                    'room_type_id' => $faker->numberBetween(1, (int)RoomType::count()),
                    'price_per_night' => $faker->numberBetween(200, 2000),
                    'room_status_id' => $freeStatusId,
                    'created_by' => 1
                ]);
            }
        }
    }
}
