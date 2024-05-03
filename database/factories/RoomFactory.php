<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();

        return [
            'number' => Room::max('number') + 1,
            'room_type_id' => $faker->numberBetween(1, (int)RoomType::count()),
            'price_per_night' => $faker->numberBetween(200, 2000),
            'created_by' => 1
        ];
    }
}
