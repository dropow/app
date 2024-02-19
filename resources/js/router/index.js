import { createRouter, createWebHistory } from 'vue-router';
import SearchPage from '../components/SearchPage.vue';
import ResultsPage from '../components/ResultsPage.vue';
import DetailsPage from '../components/DetailsPage.vue';

const routes = [
    { path: '/', component: SearchPage },
    { path: '/results', component: ResultsPage },
    { path: '/details/:id', component: DetailsPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;