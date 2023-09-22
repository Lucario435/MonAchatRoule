import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/views/**'],
            refresh: [
                'resources/routes/**',
                'routes/**',
                'resources/views/**',
            ],
            server:{
                host: '127.0.0.1:8000',
            }
        }),
    ],
});
