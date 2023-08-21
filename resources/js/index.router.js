
import { createWebHistory, createRouter } from "vue-router";

import LoginComponent from "../components/auth-page/Login.component.vue"
import Index from "../pages/welcome/Index.vue"

const routes = [{
        path: '/login',
        name: 'LoginComponent',
        component: LoginComponent
    },
    {
        path: '/',
        name: 'IndexWelcome',
        component:Index
    },
    {
        path: '/',
        name: 'stats',
        component: Index
    },
]

     const indexRouter = createRouter({
  history: createWebHistory(),
  routes,
});


export default indexRouter;