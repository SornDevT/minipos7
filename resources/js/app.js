import { createApp } from 'vue'
import App from './App.vue'
import Sidebar from './components/Sidebar.vue'
import router from './router'
import axios from 'axios'

require('./bootstrap');

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(router)
app.component('sidebar',Sidebar)
app.mount("#app-vue")
