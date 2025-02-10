import axios from 'axios';

export const getLoans = async () => axios.get('/api/loans');
export const createLoan = async (loan) => axios.post('/api/loans', loan);
export const updateLoan = async (id, loan) => axios.put(`/api/loans/${id}`, loan);
export const deleteLoan = async (id) => axios.delete(`/api/loans/${id}`);
