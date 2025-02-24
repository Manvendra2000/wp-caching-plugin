import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: '../assets',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: 'app.js',
                assetFileNames: 'style.css',
            },
        },
    }
});