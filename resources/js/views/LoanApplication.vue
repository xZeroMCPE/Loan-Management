<template>
    <div class="loan-application">
        <h2>Apply for a Loan</h2>
        <form @submit.prevent="submitApplication">
            <div>
                <label for="amount">Loan Amount:</label>
                <input id="amount" v-model="loanData.loan_amount" type="number" required />
            </div>
            <div>
                <label for="interestRate">Interest Rate (%):</label>
                <input id="interestRate" v-model="loanData.interest_rate" type="number" step="0.01" required />
            </div>
            <div>
                <label for="duration">Duration (years):</label>
                <input id="duration" v-model="loanData.loan_duration" type="number" required />
            </div>
            <button type="submit">Apply</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { createLoan } from '../services/LoanService';

export default {
    name: 'LoanApplication',
    setup() {
        const loanData = ref({
            loan_amount: '',
            interest_rate: '',
            loan_duration: '',
        });

        const submitApplication = async () => {
            try {
                await createLoan(loanData.value);
                alert('Loan application submitted successfully!');
                loanData.value = { loan_amount: '', interest_rate: '', loan_duration: '' };
            } catch (error) {
                console.error('Error submitting loan application:', error);
                alert('Failed to submit loan application. Please try again.');
            }
        };

        return { loanData, submitApplication };
    },
};
</script>
