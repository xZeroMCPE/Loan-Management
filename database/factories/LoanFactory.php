<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{

    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_amount' => $this->faker->randomFloat(2, 1000, 100000),
            'interest_rate' => $this->faker->randomFloat(2, 1, 20),
            'loan_duration' => $this->faker->numberBetween(1, 30),
            'lender_id' => User::factory(),
            'borrower_id' => User::factory(),
        ];
    }
}
