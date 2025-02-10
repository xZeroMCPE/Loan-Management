import axios from 'axios';

export const getLoans = async () => axios.get('/loans');
export const createLoan = async (loan) => axios.post('/loans', loan);
export const updateLoan = async (id, loan) => axios.put(`/loans/${id}`, loan);  // Updated API call
export const deleteLoan = async (id) => axios.delete(`/loans/${id}`);
