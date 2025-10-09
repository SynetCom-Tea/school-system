// vite.config.js
import { defineConfig } from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import vuetify from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/vite-plugin-vuetify/dist/index.js";
import Components from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/unplugin-vue-components/dist/vite.mjs";
import { VuetifyResolver } from "file:///C:/Users/MAHAMADOU/OneDrive/Documents/projet_synetcom/system_1/school/school-system/node_modules/unplugin-vue-components/dist/resolvers.mjs";
var vite_config_default = defineConfig({
  plugins: [
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    vuetify({ autoImport: true }),
    laravel({
      input: "resources/js/app.ts",
      // ssr: "resources/js/ssr.ts",
      refresh: true
    }),
    Components({
      resolvers: [
        (componentName) => {
          if (componentName === "Toast")
            return {
              name: componentName,
              from: "vue-toastification"
            };
          if (componentName === "VDataTable")
            return {
              name: componentName,
              from: "vuetify/labs/VDataTable"
            };
          if (componentName === "VDataIterator")
            return {
              name: componentName,
              from: "vuetify/labs/VDataIterator"
            };
        },
        VuetifyResolver()
      ]
    })
  ],
  optimizeDeps: {
    exclude: ["echarts/charts"]
    // Exclure la résolution automatique de ce module par Vite
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxNQUhBTUFET1VcXFxcT25lRHJpdmVcXFxcRG9jdW1lbnRzXFxcXHByb2pldF9zeW5ldGNvbVxcXFxzeXN0ZW1fMVxcXFxzY2hvb2xcXFxcc2Nob29sLXN5c3RlbVwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxcVXNlcnNcXFxcTUFIQU1BRE9VXFxcXE9uZURyaXZlXFxcXERvY3VtZW50c1xcXFxwcm9qZXRfc3luZXRjb21cXFxcc3lzdGVtXzFcXFxcc2Nob29sXFxcXHNjaG9vbC1zeXN0ZW1cXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L1VzZXJzL01BSEFNQURPVS9PbmVEcml2ZS9Eb2N1bWVudHMvcHJvamV0X3N5bmV0Y29tL3N5c3RlbV8xL3NjaG9vbC9zY2hvb2wtc3lzdGVtL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5pbXBvcnQgdnVlIGZyb20gXCJAdml0ZWpzL3BsdWdpbi12dWVcIjtcbmltcG9ydCB2dWV0aWZ5IGZyb20gXCJ2aXRlLXBsdWdpbi12dWV0aWZ5XCI7XG5pbXBvcnQgQ29tcG9uZW50cyBmcm9tIFwidW5wbHVnaW4tdnVlLWNvbXBvbmVudHMvdml0ZVwiO1xuaW1wb3J0IHsgVnVldGlmeVJlc29sdmVyIH0gZnJvbSBcInVucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3Jlc29sdmVyc1wiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgdnVlKHtcbiAgICAgICAgICAgIHRlbXBsYXRlOiB7XG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtQXNzZXRVcmxzOiB7XG4gICAgICAgICAgICAgICAgICAgIGJhc2U6IG51bGwsXG4gICAgICAgICAgICAgICAgICAgIGluY2x1ZGVBYnNvbHV0ZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgICAgICB2dWV0aWZ5KHsgYXV0b0ltcG9ydDogdHJ1ZSB9KSxcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogXCJyZXNvdXJjZXMvanMvYXBwLnRzXCIsXG4gICAgICAgICAgICAvLyBzc3I6IFwicmVzb3VyY2VzL2pzL3Nzci50c1wiLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIENvbXBvbmVudHMoe1xuICAgICAgICAgICAgcmVzb2x2ZXJzOiBbXG4gICAgICAgICAgICAgICAgKGNvbXBvbmVudE5hbWUpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgLy8gd2hlcmUgYGNvbXBvbmVudE5hbWVgIGlzIGFsd2F5cyBDYXBpdGFsQ2FzZVxuICAgICAgICAgICAgICAgICAgICBpZiAoY29tcG9uZW50TmFtZSA9PT0gXCJUb2FzdFwiKVxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBuYW1lOiBjb21wb25lbnROYW1lLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZyb206IFwidnVlLXRvYXN0aWZpY2F0aW9uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgICAgICBpZiAoY29tcG9uZW50TmFtZSA9PT0gXCJWRGF0YVRhYmxlXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU6IGNvbXBvbmVudE5hbWUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZnJvbTogXCJ2dWV0aWZ5L2xhYnMvVkRhdGFUYWJsZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcbiAgICAgICAgICAgICAgICAgICAgIGlmIChjb21wb25lbnROYW1lID09PSBcIlZEYXRhSXRlcmF0b3JcIilcbiAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4ge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmFtZTogY29tcG9uZW50TmFtZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmcm9tOiBcInZ1ZXRpZnkvbGFicy9WRGF0YUl0ZXJhdG9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgICAgIH0sXG5cbiAgICAgICAgICAgICAgICBWdWV0aWZ5UmVzb2x2ZXIoKSxcbiAgICAgICAgICAgIF0sXG4gICAgICAgIH0pLFxuICAgIF0sXG4gICAgb3B0aW1pemVEZXBzOiB7XG4gICAgICAgIGV4Y2x1ZGU6IFsnZWNoYXJ0cy9jaGFydHMnXSwgLy8gRXhjbHVyZSBsYSByXHUwMEU5c29sdXRpb24gYXV0b21hdGlxdWUgZGUgY2UgbW9kdWxlIHBhciBWaXRlXG4gICAgfSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUE2YixTQUFTLG9CQUFvQjtBQUMxZCxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sYUFBYTtBQUNwQixPQUFPLGdCQUFnQjtBQUN2QixTQUFTLHVCQUF1QjtBQUVoQyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixvQkFBb0I7QUFBQSxVQUNoQixNQUFNO0FBQUEsVUFDTixpQkFBaUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxJQUNELFFBQVEsRUFBRSxZQUFZLEtBQUssQ0FBQztBQUFBLElBQzVCLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQTtBQUFBLE1BRVAsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsV0FBVztBQUFBLE1BQ1AsV0FBVztBQUFBLFFBQ1AsQ0FBQyxrQkFBa0I7QUFFZixjQUFJLGtCQUFrQjtBQUNsQixtQkFBTztBQUFBLGNBQ0gsTUFBTTtBQUFBLGNBQ04sTUFBTTtBQUFBLFlBQ1Y7QUFDSixjQUFJLGtCQUFrQjtBQUNsQixtQkFBTztBQUFBLGNBQ0gsTUFBTTtBQUFBLGNBQ04sTUFBTTtBQUFBLFlBQ1Y7QUFDSCxjQUFJLGtCQUFrQjtBQUNsQixtQkFBTztBQUFBLGNBRUosTUFBTTtBQUFBLGNBQ04sTUFBTTtBQUFBLFlBQ1Q7QUFBQSxRQUVUO0FBQUEsUUFFQSxnQkFBZ0I7QUFBQSxNQUNwQjtBQUFBLElBQ0osQ0FBQztBQUFBLEVBQ0w7QUFBQSxFQUNBLGNBQWM7QUFBQSxJQUNWLFNBQVMsQ0FBQyxnQkFBZ0I7QUFBQTtBQUFBLEVBQzlCO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
