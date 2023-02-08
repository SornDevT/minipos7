import { createApp } from 'vue'
import App from './App.vue'
import Sidebar from './components/Sidebar.vue'
import router from './router'
import axios from 'axios'
import Vue3Storage from "vue3-storage"

require('./bootstrap');

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(router)
app.use(Vue3Storage, { namespace: "pro_"})
app.component('sidebar',Sidebar)
app.mount("#app-vue")
