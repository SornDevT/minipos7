import { createWebHistory, createRouter } from "vue-router"

import Store from "../pages/Store.vue"
import Report from "../pages/Report.vue"
import Pos from "../pages/Pos.vue"
import Transection from "../pages/Transection.vue"
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue"

export const routes = [
    {
        name: "store",
        path: "/store",
        component:Store
    },
    {
        name: "transection",
        path: "/transection",
        component:Transection
    },
    {
        name: "pos",
        path: "/pos",
        component:Pos
    },
    {
        name: "report",
        path: "/report",
        component:Report
    },
    {
        name: "login",
        path: "/login",
        component:Login
    },
    {
        name: "register",
        path: "/register",
        component:Register
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
})

export default router
