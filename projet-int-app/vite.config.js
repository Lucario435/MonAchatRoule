import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                //'resources/views/**',
            ],
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
    resolve: {
        alias: {
            '$': 'jQuery',
        },
    },
    build: {
        target: 'esnext', // or a target that supports top-level await
    },
});
