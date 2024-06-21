<?php

// namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;

// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
//  */
// class TransactionFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     public function definition(): array
//     {
//         return [
//             //
//         ];
//     }
// }



namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::inRandomOrder()->first();

        return [
            'customer_id' => $customer->id,
            'amount' => $this->faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
            'type' => $this->faker->randomElement(['debit', 'credit']),
            'date' => $this->faker->date(),
            'created_at' => $this->faker->dateTimeThisYear, // Random date within the current year
        ];
    }
}
