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

        Customer::create([
            'customer_name' => 'Customer 1',
            'email' => 'customer1@mail.com',
            'phone_number' => '11111111',
            'created_by' => 1
        ]);

        Customer::create([
            'customer_name' => 'Customer 2',
            'email' => 'customer2@mail.com',
            'phone_number' => '22222222',
            'created_by' => 1
        ]);
    }
}
