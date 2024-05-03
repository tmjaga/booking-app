<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => 'Customer',
            'email' => fake()->unique()->email(),
            'phone_number' => '1' . fake()->unique()->numerify('########'),
            'created_by' => 1
        ];
    }
}
