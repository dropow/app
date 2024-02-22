import { createRouter, createWebHistory } from 'vue-router';
import SearchPage from '../components/SearchPage.vue';
import ResultsPage from '../components/ResultsPage.vue';
import DetailsPage from '../components/DetailsPage.vue';

const routes = [
    { path: '/', name: 'SearchPage', component: SearchPage },
    { path: '/results', name: 'ResultsPage', component: ResultsPage },
    { path: '/details/:id', name: 'DetailsPage', component: DetailsPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;