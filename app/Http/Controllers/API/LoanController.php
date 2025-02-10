<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the loans.
     *
     */
    public function index()
    {
        return LoanResource::collection(Loan::with(['lender', 'borrower'])->get());
    }

    /*
     * Displays a single loan to the user, using the provided
     * loan ID, just read access only
     */
    public function show(Loan $loan)
    {

        return response()->json($loan);
    }

    /*
     * Creates a new loan in the system
     */
    public function store(Request $request)
    {
        $request->validate([
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'loan_duration' => 'required|integer',
            'borrower_id' => 'required|exists:users,id',
        ]);

        $loan = Loan::create([
            'loan_amount' => $request->loan_amount,
            'interest_rate' => $request->interest_rate,
            'loan_duration' => $request->loan_duration,
            'lender_id' => Auth::id(),
            'borrower_id' => $request->borrower_id,
        ]);

        return response()->json($loan);
    }

    /*
     * Updates an existing loan, only the lender that started out
     * the loan can update the loan
     */
    public function update(Request $request, Loan $loan)
    {
        if (Auth::id() !== $loan->lender_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $loan->update($request->only(['loan_amount', 'interest_rate', 'loan_duration']));
        return response()->json($loan);
    }

    /*
     * Deletes a loan from the system
     */
    public function destroy(Loan $loan)
    {
        if (Auth::id() !== $loan->lender_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        /*
         * Delete the loan record, but this is an actual soft delete, which just sets the
         * deleted_at, it's crucial to still have this on the database to have the 'record'
         * just for future purposes.
         *
         */
        $loan->delete();
        return response()->json(['message' => 'Loan deleted successfully']);
    }
}
