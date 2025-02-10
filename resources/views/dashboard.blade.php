<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Your Loans</h3>
                    <table class="w-full border-collapse border border-gray-500">
                        <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="border border-gray-500 p-2">Loan Amount</th>
                            <th class="border border-gray-500 p-2">Interest Rate</th>
                            <th class="border border-gray-500 p-2">Duration</th>
                            <th class="border border-gray-500 p-2">Borrower</th>
                            <th class="border border-gray-500 p-2">Lender</th>
                            <th class="border border-gray-500 p-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Models\Loan::with(['lender', 'borrower'])->get() as $loan)
                            <tr class="border border-gray-500">
                                <td class="border border-gray-500 p-2">{{ number_format($loan->loan_amount, 2) }}</td>
                                <td class="border border-gray-500 p-2">{{ $loan->interest_rate }}%</td>
                                <td class="border border-gray-500 p-2">{{ $loan->loan_duration }} years</td>
                                <td class="border border-gray-500 p-2">{{ $loan->borrower->name }}</td>
                                <td class="border border-gray-500 p-2">{{ $loan->lender->name }}</td>
                                <td class="border border-gray-500 p-2">
                                    @if(auth()->id() === $loan->lender_id)
                                        <a href="{{ route('loans.update', $loan) }}" class="text-blue-500">Edit</a>
                                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <h3 class="text-lg font-bold mt-6 mb-4">Create New Loan</h3>
                    <form method="POST" action="{{ route('loans.store') }}" class="space-y-4">
                        @csrf
                        <input type="number" name="loan_amount" placeholder="Loan Amount" class="w-full p-2 border rounded bg-gray-100 text-black" required>
                        <input type="number" name="interest_rate" placeholder="Interest Rate" class="w-full p-2 border rounded bg-gray-100 text-black" required>
                        <input type="number" name="loan_duration" placeholder="Duration (Years)" class="w-full p-2 border rounded bg-gray-100 text-black" required>
                        <select name="borrower_id" class="w-full p-2 border rounded bg-gray-100 text-black" required>
                            <option value="">Select Borrower</option>
                            @foreach(\App\Models\User::all()->except(Auth::id()) as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Loan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
