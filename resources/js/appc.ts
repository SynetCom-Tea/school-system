import "./bootstrap";
import "../css/app.css";

import { createApp, h, DefineComponent } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Ziggy } from './ziggy';
import { InertiaProgress } from "@inertiajs/progress";
import { createVuetify ,type ThemeDefinition} from 'vuetify';
import VueGates from 'vue-gates';
import 'vuetify/styles'
import "vuetify/dist/vuetify.min.css";
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labsComponents from 'vuetify/labs/components'
import { VDataTable } from 'vuetify/labs/VDataTable'

// InertiaProgress.init({ color: '#2880ff' });
InertiaProgress.init({ color: '#7d002c' });
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
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
    // theme: {
    //         dark: true,
    //         options: { customProperties: true },
    //         themes: {
    //             dark: {
    //                 primary: {
    //                     base: "#099b63",
    //                     darken1: "#04c279"
    //                 },
    //                 accent: "#250032",
    //                 secondary: "#97812F",
    //                 info: {
    //                     base: "#1FFFF1",
    //                     darken1: "#450b5a",
    //                     darken2: "#1125c0",
    //                     darken3: "#40bfa4"
    //                 },
    //                 warning: 'orange',
    //                 error: 'red',
    //                 success:'green',
    //                 anchor: "#1FFFF1"
    //             }
    //         },
    //     }
})
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
        .use(plugin)
        .use(ZiggyVue, Ziggy)
        .use(vuetify)
        .use(VueGates)
      .mount(el);
    },

});






