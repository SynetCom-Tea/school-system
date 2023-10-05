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
import { VDataIterator } from 'vuetify/labs/VDataIterator'

 import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueSweetalert2 from 'vue-sweetalert2';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import 'sweetalert2/dist/sweetalert2.min.css';
import { store } from './store'
import { VStepper } from 'vuetify/labs/VStepper'

import { createWebHistory, createRouter,createWebHashHistory} from "vue-router";
import LoginComponent from "./components/auth-page/Login.component.vue";

import TextField from "../js/Components/customizedComponents/TextField.vue"
import Button from "../js/Components/customizedComponents/Button.vue"
import DateRangePicker from "../js/Components/customizedComponents/DateRangePicker.vue"
import Btn from "../js/Components/Btn.vue";
import Dialog from "../js/components/customizedComponents/Dialog.vue";
import Index from "./pages/welcome/Index.vue";
import Button from '../js/components/customizedComponents/Button.vue'
import TextField from '../js/components/customizedComponents/TextField.vue'
import Autocomplete from '../js/components/customizedComponents/Autocomplete.vue'
import Select from '../js/components/customizedComponents/Select.vue'
import ModalDetailUpdate from '../js/components/customizedComponents/ModalDetailUpdate.vue'
import Toolbar from '../js/components/customizedComponents/Toolbar.vue'
import Datatable from "../js/components/customizedComponents/Datatable.vue"




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
        dark: false,
        defaultTheme: "myAllBlackTheme",
        themes: {
          myAllBlackTheme,
        },
      },
    components: {
      VDataTable,
      VDataIterator,
      VStepper,

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
        .use(store)
        .use(vuetify)
        .use(VueGates)
        .use(Vuex)
        .component('TextField', TextField)
        .component('Button', Button)
        .component('Autocomplete', Autocomplete)
        .component('Select', Select)
        .component('ModalDetailUpdate', ModalDetailUpdate)
        .component('Toolbar',Toolbar )
        .use(VueAxios, axios)
        .component('VueDatePicker', VueDatePicker)
        .component('text-field', TextField)
        .component('date-range-picker', DateRangePicker)
        .component('btn', Btn)
        .component('Datatable', Datatable)
        .component('Dialog', Dialog)
        .use(VueSweetalert2, options)
        .component('dialog-component', Dialog)
        .mount(el);
    },
    progress: {
        color:'#7d002c',
    },
});
