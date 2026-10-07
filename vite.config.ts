import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  base: './',
  build: {
    outDir: 'dist',
    manifest: true,
    rollupOptions: {
      input: {
        app: resolve(__dirname, 'src/ts/app.ts'),
        style: resolve(__dirname, 'src/css/app.css'),
      },
    },
  },
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    https: true,
    origin: 'https://black-brew.ddev.site:5173',
  },
});
