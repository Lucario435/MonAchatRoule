// vite.config.js
import { defineConfig } from "file:///C:/Users/benra/Documents/GitHub/MonAchatRoule/projet-int-app/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/benra/Documents/GitHub/MonAchatRoule/projet-int-app/node_modules/laravel-vite-plugin/dist/index.mjs";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/views/**"
      ],
      refresh: [
        "resources/routes/**",
        "routes/**"
        // 'resources/views/*',
      ],
      server: {
        host: "127.0.0.1:8000"
      }
    })
  ],
  resolve: {
    alias: {
      "$": "jQuery"
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxiZW5yYVxcXFxEb2N1bWVudHNcXFxcR2l0SHViXFxcXE1vbkFjaGF0Um91bGVcXFxccHJvamV0LWludC1hcHBcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXFVzZXJzXFxcXGJlbnJhXFxcXERvY3VtZW50c1xcXFxHaXRIdWJcXFxcTW9uQWNoYXRSb3VsZVxcXFxwcm9qZXQtaW50LWFwcFxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovVXNlcnMvYmVucmEvRG9jdW1lbnRzL0dpdEh1Yi9Nb25BY2hhdFJvdWxlL3Byb2pldC1pbnQtYXBwL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFtcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy92aWV3cy8qKicsXG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgcmVmcmVzaDogW1xuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvcm91dGVzLyoqJyxcbiAgICAgICAgICAgICAgICAncm91dGVzLyoqJyxcbiAgICAgICAgICAgICAgICAvLyAncmVzb3VyY2VzL3ZpZXdzLyonLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHNlcnZlcjp7XG4gICAgICAgICAgICAgICAgaG9zdDogJzEyNy4wLjAuMTo4MDAwJyxcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSksXG4gICAgXSxcbiAgICByZXNvbHZlOiB7XG4gICAgICAgIGFsaWFzOiB7XG4gICAgICAgICAgICAnJCc6ICdqUXVlcnknXG4gICAgICAgIH0sXG4gICAgfSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFvWCxTQUFTLG9CQUFvQjtBQUNqWixPQUFPLGFBQWE7QUFFcEIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLE1BQ0o7QUFBQSxNQUNBLFNBQVM7QUFBQSxRQUNMO0FBQUEsUUFDQTtBQUFBO0FBQUEsTUFFSjtBQUFBLE1BQ0EsUUFBTztBQUFBLFFBQ0gsTUFBTTtBQUFBLE1BQ1Y7QUFBQSxJQUNKLENBQUM7QUFBQSxFQUNMO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDTCxPQUFPO0FBQUEsTUFDSCxLQUFLO0FBQUEsSUFDVDtBQUFBLEVBQ0o7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
