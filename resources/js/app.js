import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import axios from 'axios';

const app = createApp(App);

// AxiosをVueのグローバルプロパティとして設定
app.config.globalProperties.$http = axios;

app.use(router).mount('#app');