import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from "./router.js";
import App from "./components/layouts/App.vue";
import * as bootstrap from 'bootstrap';
import axios from 'axios';

window.bootstrap = bootstrap;
window.axios = axios;

const pinia = createPinia();
const app = createApp(App);

app.use(pinia).use(router).mount("#app");