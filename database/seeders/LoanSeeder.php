<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create fake users to be used as a lender/borrowers using the user factory
         * @see UserFactory
         */
        $lenders = User::factory()->count(10)->create();
        $borrowers = User::factory()->count(10)->create();

        foreach ($lenders as $lender) {
            Loan::factory()->count(5)->create([
                'lender_id' => $lender->id,
                'borrower_id' => $borrowers->random()->id,
                'loan_amount' => fake()->randomFloat(2, 1000, 100000),
                'interest_rate' => fake()->randomFloat(2, 1, 20),
                'loan_duration' => fake()->numberBetween(1, 30)
            ]);
        }
    }
}
