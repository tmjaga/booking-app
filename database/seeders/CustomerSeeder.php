<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::truncate();

        Customer::create([
            'customer_name' => 'Admin',
            'email' => 'customer1@mail.com',
            'phone_number' => '11111111',
            'is_admin' => true,
        ]);

        Customer::create([
            'customer_name' => 'User',
            'email' => 'customer2@mail.com',
            'phone_number' => '22222222',
            'created_by' => 1
        ]);
    }
}
