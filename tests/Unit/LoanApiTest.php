<?php

namespace Tests\Unit;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanApiTest extends TestCase
{
    use RefreshDatabase;

    protected $lender;
    protected $borrower;
    protected $loan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->lender = User::factory()->create();
        $this->borrower = User::factory()->create();

        $this->loan = Loan::factory()->create([
            'lender_id' => $this->lender->id,
            'borrower_id' => $this->borrower->id,
        ]);
    }

    public function test_can_list_loans()
    {
        $response = $this->actingAs($this->lender)->getJson(route('loans.index'));
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [['id', 'loan_amount', 'interest_rate', 'loan_duration']]
        ]);
    }

    public function test_can_create_loan()
    {
        $loanData = [
            'loan_amount' => 5000,
            'interest_rate' => 5.5,
            'loan_duration' => 3,
            'borrower_id' => $this->borrower->id,
        ];

        $response = $this->actingAs($this->lender)->postJson(route('loans.store'), $loanData);
        $response->assertStatus(200)->assertJsonFragment(['loan_amount' => 5000]);
    }

    public function test_can_view_a_loan()
    {
        $response = $this->actingAs($this->lender)->getJson(route('loans.show', $this->loan->id));
        $response->assertJson(['loan_amount' => (string) $this->loan->loan_amount]);
    }

    public function test_can_update_loan()
    {
        $updatedData = ['loan_amount' => 6000, 'interest_rate' => 6.0, 'loan_duration' => 4];

        $response = $this->actingAs($this->lender)->putJson(route('loans.update', $this->loan->id), $updatedData);
        $response->assertStatus(200)->assertJsonFragment(['loan_amount' => 6000]);
    }

    public function test_can_delete_loan()
    {
        $response = $this->actingAs($this->lender)->deleteJson(route('loans.destroy', $this->loan->id));
        $response->assertStatus(200)->assertJson(['message' => 'Loan deleted successfully']);
    }
}
