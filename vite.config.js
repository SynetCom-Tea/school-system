import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from 'vite-plugin-vuetify';
import Components from 'unplugin-vue-components/vite';
import {
    VuetifyResolver,
} from 'unplugin-vue-components/resolvers'

export default defineConfig({
    build: {

   /** If you set esmExternals to true, this plugins assumes that
     all external dependencies are ES modules */

   commonjsOptions: {
      esmExternals: true
   },
},
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({ autoImport: true }),
           Components({
            resolvers:[
                (componentName) => {
                    // where `componentName` is always CapitalCase
                    // if (componentName === 'Toast')
                    //     return { name: componentName, from: 'vue-toastification' }
                    if (componentName === 'VDataTable')
                        return { name: componentName, from: 'vuetify/labs/VDataTable' }
                },
                VuetifyResolver()
            ]
        })
    ],
});
