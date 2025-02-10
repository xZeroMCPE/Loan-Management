import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import LoanList from '../views/LoanList.vue';
import LoanApplication from '../views/LoanApplication.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/loans', component: LoanList },
    { path: '/apply', component: LoanApplication },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
