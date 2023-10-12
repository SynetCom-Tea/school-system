// vite.config.js
import { defineConfig } from "file:///C:/Users/Chine/Desktop/school-system/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/Chine/Desktop/school-system/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///C:/Users/Chine/Desktop/school-system/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import vuetify from "file:///C:/Users/Chine/Desktop/school-system/node_modules/vite-plugin-vuetify/dist/index.js";
import Components from "file:///C:/Users/Chine/Desktop/school-system/node_modules/unplugin-vue-components/dist/vite.mjs";
import { VuetifyResolver } from "file:///C:/Users/Chine/Desktop/school-system/node_modules/unplugin-vue-components/dist/resolvers.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: "resources/js/app.ts",
      ssr: "resources/js/ssr.ts",
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    vuetify({ autoImport: true }),
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
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxDaGluZVxcXFxEZXNrdG9wXFxcXHNjaG9vbC1zeXN0ZW1cIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXFVzZXJzXFxcXENoaW5lXFxcXERlc2t0b3BcXFxcc2Nob29sLXN5c3RlbVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovVXNlcnMvQ2hpbmUvRGVza3RvcC9zY2hvb2wtc3lzdGVtL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSBcInZpdGVcIjtcbmltcG9ydCBsYXJhdmVsIGZyb20gXCJsYXJhdmVsLXZpdGUtcGx1Z2luXCI7XG5pbXBvcnQgdnVlIGZyb20gXCJAdml0ZWpzL3BsdWdpbi12dWVcIjtcbmltcG9ydCB2dWV0aWZ5IGZyb20gXCJ2aXRlLXBsdWdpbi12dWV0aWZ5XCI7XG5pbXBvcnQgQ29tcG9uZW50cyBmcm9tIFwidW5wbHVnaW4tdnVlLWNvbXBvbmVudHMvdml0ZVwiO1xuaW1wb3J0IHsgVnVldGlmeVJlc29sdmVyIH0gZnJvbSBcInVucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3Jlc29sdmVyc1wiO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogXCJyZXNvdXJjZXMvanMvYXBwLnRzXCIsXG4gICAgICAgICAgICBzc3I6IFwicmVzb3VyY2VzL2pzL3Nzci50c1wiLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG4gICAgICAgIHZ1ZSh7XG4gICAgICAgICAgICB0ZW1wbGF0ZToge1xuICAgICAgICAgICAgICAgIHRyYW5zZm9ybUFzc2V0VXJsczoge1xuICAgICAgICAgICAgICAgICAgICBiYXNlOiBudWxsLFxuICAgICAgICAgICAgICAgICAgICBpbmNsdWRlQWJzb2x1dGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB9LFxuICAgICAgICB9KSxcbiAgICAgICAgdnVldGlmeSh7IGF1dG9JbXBvcnQ6IHRydWUgfSksXG4gICAgICAgIENvbXBvbmVudHMoe1xuICAgICAgICAgICAgcmVzb2x2ZXJzOiBbXG4gICAgICAgICAgICAgICAgKGNvbXBvbmVudE5hbWUpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgLy8gd2hlcmUgYGNvbXBvbmVudE5hbWVgIGlzIGFsd2F5cyBDYXBpdGFsQ2FzZVxuICAgICAgICAgICAgICAgICAgICBpZiAoY29tcG9uZW50TmFtZSA9PT0gXCJUb2FzdFwiKVxuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBuYW1lOiBjb21wb25lbnROYW1lLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZyb206IFwidnVlLXRvYXN0aWZpY2F0aW9uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgICAgICBpZiAoY29tcG9uZW50TmFtZSA9PT0gXCJWRGF0YVRhYmxlXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU6IGNvbXBvbmVudE5hbWUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZnJvbTogXCJ2dWV0aWZ5L2xhYnMvVkRhdGFUYWJsZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgfTtcbiAgICAgICAgICAgICAgICAgICAgIGlmIChjb21wb25lbnROYW1lID09PSBcIlZEYXRhSXRlcmF0b3JcIilcbiAgICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4ge1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmFtZTogY29tcG9uZW50TmFtZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmcm9tOiBcInZ1ZXRpZnkvbGFicy9WRGF0YUl0ZXJhdG9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgfTtcblxuICAgICAgICAgICAgICAgIH0sXG5cbiAgICAgICAgICAgICAgICBWdWV0aWZ5UmVzb2x2ZXIoKSxcbiAgICAgICAgICAgIF0sXG4gICAgICAgIH0pLFxuICAgIF0sXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBd1MsU0FBUyxvQkFBb0I7QUFDclUsT0FBTyxhQUFhO0FBQ3BCLE9BQU8sU0FBUztBQUNoQixPQUFPLGFBQWE7QUFDcEIsT0FBTyxnQkFBZ0I7QUFDdkIsU0FBUyx1QkFBdUI7QUFFaEMsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLE1BQ1AsS0FBSztBQUFBLE1BQ0wsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsSUFBSTtBQUFBLE1BQ0EsVUFBVTtBQUFBLFFBQ04sb0JBQW9CO0FBQUEsVUFDaEIsTUFBTTtBQUFBLFVBQ04saUJBQWlCO0FBQUEsUUFDckI7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsSUFDRCxRQUFRLEVBQUUsWUFBWSxLQUFLLENBQUM7QUFBQSxJQUM1QixXQUFXO0FBQUEsTUFDUCxXQUFXO0FBQUEsUUFDUCxDQUFDLGtCQUFrQjtBQUVmLGNBQUksa0JBQWtCO0FBQ2xCLG1CQUFPO0FBQUEsY0FDSCxNQUFNO0FBQUEsY0FDTixNQUFNO0FBQUEsWUFDVjtBQUNKLGNBQUksa0JBQWtCO0FBQ2xCLG1CQUFPO0FBQUEsY0FDSCxNQUFNO0FBQUEsY0FDTixNQUFNO0FBQUEsWUFDVjtBQUNILGNBQUksa0JBQWtCO0FBQ2xCLG1CQUFPO0FBQUEsY0FFSixNQUFNO0FBQUEsY0FDTixNQUFNO0FBQUEsWUFDVDtBQUFBLFFBRVQ7QUFBQSxRQUVBLGdCQUFnQjtBQUFBLE1BQ3BCO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
