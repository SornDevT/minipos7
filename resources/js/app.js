import { createApp } from 'vue'
import App from './App.vue'
import Sidebar from './components/Sidebar.vue'
import router from './router'
import axios from 'axios'
import Vue3Storage from "vue3-storage"
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import Cleave from 'vue-cleave-component'
import Pagination from './components/Pagination.vue'

require('./bootstrap');

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(VueSweetalert2)
app.use(router)
app.use(Cleave)
app.use(Vue3Storage, { namespace: "pro_"})
app.component('sidebar',Sidebar)
app.component('pagination',Pagination)
app.mount("#app-vue")
