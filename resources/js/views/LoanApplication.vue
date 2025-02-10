<template>
    <div class="loan-application">
        <h2>Apply for a Loan</h2>
        <form @submit.prevent="submitApplication">
            <div>
                <label for="amount">Loan Amount:</label>
                <input id="amount" v-model="loanData.amount" type="number" required />
            </div>
            <div>
                <label for="interestRate">Interest Rate (%):</label>
                <input id="interestRate" v-model="loanData.interest_rate" type="number" step="0.01" required />
            </div>
            <div>
                <label for="duration">Duration (years):</label>
                <input id="duration" v-model="loanData.duration" type="number" required />
            </div>
            <button type="submit">Apply</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import LoanService from '../services/LoanService';

export default {
    name: 'LoanApplication',
    setup() {
        const loanData = ref({
            amount: '',
            interest_rate: '',
            duration: '',
        });

        const submitApplication = async () => {
            try {
                await LoanService.applyForLoan(loanData.value);
                alert('Loan application submitted successfully!');
                loanData.value = { amount: '', interest_rate: '', duration: '' };
            } catch (error) {
                console.error('Error submitting loan application:', error);
                alert('Failed to submit loan application. Please try again.');
            }
        };

        return { loanData, submitApplication };
    },
};
</script>
