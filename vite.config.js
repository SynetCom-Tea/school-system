
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
            // ssr: "resources/js/ssr.ts",

            // Surveiller uniquement les fichiers utiles
            refresh: [
                "resources/views/**/*.blade.php",
                "routes/**/*.php",
            ],
        }),

        Components({
            resolvers: [
                (componentName) => {
                    if (componentName === "Toast") {
                        return {
                            name: componentName,
                            from: "vue-toastification",
                        };
                    }

                    if (componentName === "VDataTable") {
                        return {
                            name: componentName,
                            from: "vuetify/labs/VDataTable",
                        };
                    }

                    if (componentName === "VDataIterator") {
                        return {
                            name: componentName,
                            from: "vuetify/labs/VDataIterator",
                        };
                    }
                },

                VuetifyResolver(),
            ],
        }),
    ],

    // Empêcher Vite de surveiller les sessions Laravel
    server: {
        watch: {
            ignored: [
                "**/storage/framework/sessions/**",
            ],
        },
    },

    optimizeDeps: {
        exclude: ["echarts/charts"],
    },
});
