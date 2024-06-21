<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Satish Kumar Sharma',
        //     'email' => '00satish2015@gmail.com',
        // ]);

        Customer::factory(5)->create();

        Transaction::factory(50)->create();
    }
}
