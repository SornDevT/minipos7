import { createApp } from 'vue'
import App from './App.vue'
import Sidebar from './components/Sidebar.vue'

require('./bootstrap');

const app = createApp(App)
app.component('sidebar',Sidebar)
app.mount("#app-vue")
