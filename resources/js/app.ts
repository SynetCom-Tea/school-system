import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createVuetify, type ThemeDefinition } from 'vuetify';
import { InertiaProgress } from "@inertiajs/progress";
import VueGates from 'vue-gates';
import 'vuetify/styles'
import "vuetify/dist/vuetify.min.css";
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labsComponents from 'vuetify/labs/components'
import { VDataTable } from 'vuetify/labs/VDataTable'
 import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSweetalert2 from 'vue-sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import 'sweetalert2/dist/sweetalert2.min.css';
import { store } from './store'

import { createWebHistory, createRouter } from "vue-router";

import LoginComponent from "./components/auth-page/Login.component.vue";
import PageToolbar from "../js/Components/PageToolbar.vue"
import Btn from "../js/Components/Btn.vue";
import Index from "./pages/welcome/Index.vue";

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



const options = {
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
};

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
InertiaProgress.init({ color: '#7d002c' });

 const myAllBlackTheme: ThemeDefinition = {
     dark: false,
      light: true,
      colors: {
        // background: "white",
        // surface: "white",
        primary: '#004980',
        "primary-darken-1": "#000000",
        // secondary: "#c9ebff",
         secondary: "#7d002c",
        "secondary-darken-1": "#000000",
        error: "#ff0000",
        info: "#809fff",
        success: "#008000",
        warning: "#ff9400",
      },
    };
const vuetify = createVuetify({
      theme: {
        defaultTheme: "myAllBlackTheme",
        themes: {
          myAllBlackTheme,
        },
      },
    components: {
        VDataTable,
    },
    directives,
    labsComponents,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },

})
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin}) {
      return createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(indexRouter)
        .use(store)
        .use(vuetify)
        .use(VueGates)
        .use(Vuex)
        .use(VueAxios, axios)
        .component('VueDatePicker', VueDatePicker)
        .component('page-toolbar', PageToolbar)
        .component('btn', Btn)
        .use(VueSweetalert2, options)
        .mount(el);
    },
    progress: {
        color:'#7d002c',
    },
});
