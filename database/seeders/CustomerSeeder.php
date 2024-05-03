<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::truncate();

        Customer::factory()->sequence(function () {
            static $id = 1;
            $index = $id ++;
            return [
                'customer_name' => 'Customer ' . $index,
                'email' => 'customer' . $index .'@mail.com',
            ];
        })->count(2)->create();
    }
}
