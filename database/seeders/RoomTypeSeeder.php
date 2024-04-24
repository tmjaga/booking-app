<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            'Standard Room',
            'Suite',
            'Deluxe Room',
            'Family Room',
            'Adjoining Rooms',
            'Accessible Room',
            'Presidential Suite',
            'Penthouse Suite',
            'Executive Room'
        ];
        sort($roomTypes);

        RoomType::truncate();

        foreach ($roomTypes as $roomType) {
            RoomType::create(['type' => $roomType]);
        }
    }
}
