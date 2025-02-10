<template>
    <div class="loan-list">
        <h2>Loan List</h2>
        <ul v-if="loans.length">
            <li v-for="loan in loans" :key="loan.id">
                Amount: ${{ loan.amount }}, Interest Rate: {{ loan.interest_rate }}%, Duration: {{ loan.duration }} years
                <button @click="editLoan(loan)">Edit</button>
                <button @click="deleteLoan(loan.id)">Delete</button>
            </li>
        </ul>
        <p v-else>No loans found.</p>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import LoanService from '../services/LoanService';

export default {
    name: 'LoanList',
    setup() {
        const loans = ref([]);

        const fetchLoans = async () => {
            try {
                const response = await LoanService.getLoans();
                loans.value = response.data;
            } catch (error) {
                console.error('Error fetching loans:', error);
            }
        };

        const editLoan = (loan) => {
            // Implement edit functionality here
            alert(`Editing loan with ID ${loan.id}`);
        };

        const deleteLoan = async (id) => {
            try {
                await LoanService.deleteLoan(id);
                fetchLoans();
            } catch (error) {
                console.error('Error deleting loan:', error);
            }
        };

        onMounted(fetchLoans);

        return { loans, editLoan, deleteLoan };
    },
};
</script>
