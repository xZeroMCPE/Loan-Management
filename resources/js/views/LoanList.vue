<template>
    <div class="loan-list">
        <h2>Loan List</h2>
        <ul v-if="loans.length">
            <li v-for="loan in loans" :key="loan.id">
                Amount: ${{ loan.loan_amount }}, Interest Rate: {{ loan.interest_rate }}%, Duration: {{ loan.loan_duration }} years
                <button @click="editLoan(loan)">Edit</button>
                <button @click="deleteLoan(loan.id)">Delete</button>
            </li>
        </ul>
        <p v-else>No loans found.</p>

        <!-- Edit Loan Modal -->
        <div v-if="isEditing" class="modal">
            <div class="modal-content">
                <h3>Edit Loan</h3>
                <form @submit.prevent="submitEdit">
                    <div>
                        <label for="loan_amount">Loan Amount:</label>
                        <input id="loan_amount" v-model="editedLoan.loan_amount" type="number" required />
                    </div>
                    <div>
                        <label for="interest_rate">Interest Rate (%):</label>
                        <input id="interest_rate" v-model="editedLoan.interest_rate" type="number" step="0.01" required />
                    </div>
                    <div>
                        <label for="loan_duration">Loan Duration (years):</label>
                        <input id="loan_duration" v-model="editedLoan.loan_duration" type="number" required />
                    </div>
                    <button type="submit">Save Changes</button>
                    <button @click="closeEditModal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { getLoans, deleteLoan, updateLoan } from '../services/LoanService';

export default {
    name: 'LoanList',
    setup() {
        const loans = ref([]);
        const isEditing = ref(false);
        const editedLoan = ref({
            id: null,
            loan_amount: '',
            interest_rate: '',
            loan_duration: '',
        });

        const fetchLoans = async () => {
            try {
                const response = await getLoans();
                loans.value = response.data;
            } catch (error) {
                console.error('Error fetching loans:', error);
            }
        };

        const editLoan = (loan) => {
            editedLoan.value = {...loan};
            isEditing.value = true;
        };

        const submitEdit = async () => {
            try {
                await updateLoan(editedLoan.value.id, editedLoan.value);
                fetchLoans(); // Refresh the loan list
                closeEditModal();
            } catch (error) {
                console.error('Error updating loan:', error);
            }
        };

        const closeEditModal = () => {
            isEditing.value = false;
            editedLoan.value = {id: null, loan_amount: '', interest_rate: '', loan_duration: ''};
        };

        const deleteLoanById = async (id) => {
            try {
                await deleteLoan(id);
                fetchLoans();
            } catch (error) {
                console.error('Error deleting loan:', error);
            }
        };

        onMounted(fetchLoans);

        return {loans, editLoan, deleteLoan: deleteLoanById, isEditing, editedLoan, submitEdit, closeEditModal};
    },
};
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
}

button {
    margin-top: 10px;
}
</style>
