// vite.config.js
import { defineConfig } from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/vite/dist/node/index.js";
import laravel from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import vuetify from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/vite-plugin-vuetify/dist/index.js";
import Components from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/unplugin-vue-components/dist/vite.mjs";
import { VuetifyResolver } from "file:///Users/mac/Documents/Projets/SynetCom/school-system/node_modules/unplugin-vue-components/dist/resolvers.mjs";
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
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvVXNlcnMvbWFjL0RvY3VtZW50cy9Qcm9qZXRzL1N5bmV0Q29tL3NjaG9vbC1zeXN0ZW1cIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIi9Vc2Vycy9tYWMvRG9jdW1lbnRzL1Byb2pldHMvU3luZXRDb20vc2Nob29sLXN5c3RlbS92aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vVXNlcnMvbWFjL0RvY3VtZW50cy9Qcm9qZXRzL1N5bmV0Q29tL3NjaG9vbC1zeXN0ZW0vdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tIFwidml0ZVwiO1xuaW1wb3J0IGxhcmF2ZWwgZnJvbSBcImxhcmF2ZWwtdml0ZS1wbHVnaW5cIjtcbmltcG9ydCB2dWUgZnJvbSBcIkB2aXRlanMvcGx1Z2luLXZ1ZVwiO1xuaW1wb3J0IHZ1ZXRpZnkgZnJvbSBcInZpdGUtcGx1Z2luLXZ1ZXRpZnlcIjtcbmltcG9ydCBDb21wb25lbnRzIGZyb20gXCJ1bnBsdWdpbi12dWUtY29tcG9uZW50cy92aXRlXCI7XG5pbXBvcnQgeyBWdWV0aWZ5UmVzb2x2ZXIgfSBmcm9tIFwidW5wbHVnaW4tdnVlLWNvbXBvbmVudHMvcmVzb2x2ZXJzXCI7XG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBcInJlc291cmNlcy9qcy9hcHAudHNcIixcbiAgICAgICAgICAgIHNzcjogXCJyZXNvdXJjZXMvanMvc3NyLnRzXCIsXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKHtcbiAgICAgICAgICAgIHRlbXBsYXRlOiB7XG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtQXNzZXRVcmxzOiB7XG4gICAgICAgICAgICAgICAgICAgIGJhc2U6IG51bGwsXG4gICAgICAgICAgICAgICAgICAgIGluY2x1ZGVBYnNvbHV0ZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgICAgICB2dWV0aWZ5KHsgYXV0b0ltcG9ydDogdHJ1ZSB9KSxcbiAgICAgICAgQ29tcG9uZW50cyh7XG4gICAgICAgICAgICByZXNvbHZlcnM6IFtcbiAgICAgICAgICAgICAgICAoY29tcG9uZW50TmFtZSkgPT4ge1xuICAgICAgICAgICAgICAgICAgICAvLyB3aGVyZSBgY29tcG9uZW50TmFtZWAgaXMgYWx3YXlzIENhcGl0YWxDYXNlXG4gICAgICAgICAgICAgICAgICAgIGlmIChjb21wb25lbnROYW1lID09PSBcIlRvYXN0XCIpXG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5hbWU6IGNvbXBvbmVudE5hbWUsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZnJvbTogXCJ2dWUtdG9hc3RpZmljYXRpb25cIixcbiAgICAgICAgICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgICAgIGlmIChjb21wb25lbnROYW1lID09PSBcIlZEYXRhVGFibGVcIilcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbmFtZTogY29tcG9uZW50TmFtZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmcm9tOiBcInZ1ZXRpZnkvbGFicy9WRGF0YVRhYmxlXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgICAgICAgaWYgKGNvbXBvbmVudE5hbWUgPT09IFwiVkRhdGFJdGVyYXRvclwiKVxuICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiB7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBuYW1lOiBjb21wb25lbnROYW1lLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZyb206IFwidnVldGlmeS9sYWJzL1ZEYXRhSXRlcmF0b3JcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgICAgIFZ1ZXRpZnlSZXNvbHZlcigpLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgfSksXG4gICAgXSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUEyVSxTQUFTLG9CQUFvQjtBQUN4VyxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sYUFBYTtBQUNwQixPQUFPLGdCQUFnQjtBQUN2QixTQUFTLHVCQUF1QjtBQUVoQyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsTUFDUCxLQUFLO0FBQUEsTUFDTCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixvQkFBb0I7QUFBQSxVQUNoQixNQUFNO0FBQUEsVUFDTixpQkFBaUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxJQUNELFFBQVEsRUFBRSxZQUFZLEtBQUssQ0FBQztBQUFBLElBQzVCLFdBQVc7QUFBQSxNQUNQLFdBQVc7QUFBQSxRQUNQLENBQUMsa0JBQWtCO0FBRWYsY0FBSSxrQkFBa0I7QUFDbEIsbUJBQU87QUFBQSxjQUNILE1BQU07QUFBQSxjQUNOLE1BQU07QUFBQSxZQUNWO0FBQ0osY0FBSSxrQkFBa0I7QUFDbEIsbUJBQU87QUFBQSxjQUNILE1BQU07QUFBQSxjQUNOLE1BQU07QUFBQSxZQUNWO0FBQ0gsY0FBSSxrQkFBa0I7QUFDbEIsbUJBQU87QUFBQSxjQUVKLE1BQU07QUFBQSxjQUNOLE1BQU07QUFBQSxZQUNUO0FBQUEsUUFFVDtBQUFBLFFBRUEsZ0JBQWdCO0FBQUEsTUFDcEI7QUFBQSxJQUNKLENBQUM7QUFBQSxFQUNMO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
