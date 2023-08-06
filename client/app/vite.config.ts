import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
console.log(process.cwd() + '/.env');
// https://vitejs.dev/config/
export default defineConfig({
  // dev server port
  server: {
    port: 3000,
    watch: {
      usePolling: true
    }
  },
  // add folders aliases
  resolve: {
    alias: {
      '@': '/src'
    }
  },
  plugins: [vue()]
});
