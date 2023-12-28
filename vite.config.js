import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "vite-plugin-vuetify";
import Components from "unplugin-vue-components/vite";
import { VuetifyResolver } from "unplugin-vue-components/resolvers";

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({ autoImport: true }),
        laravel({
            input: "resources/js/app.ts",
            ssr: "resources/js/ssr.ts",
            refresh: true,
        }),
        Components({
            resolvers: [
                (componentName) => {
                    // where `componentName` is always CapitalCase
                    if (componentName === "Toast")
                        return {
                            name: componentName,
                            from: "vue-toastification",
                        };
                    if (componentName === "VDataTable")
                        return {
                            name: componentName,
                            from: "vuetify/labs/VDataTable",
                        };
                     if (componentName === "VDataIterator")
                         return {

                            name: componentName,
                            from: "vuetify/labs/VDataIterator",
                         };

                },

                VuetifyResolver(),
            ],
        }),
    ],
    optimizeDeps: {
        exclude: ['echarts/charts'], // Exclure la résolution automatique de ce module par Vite
    },
});
