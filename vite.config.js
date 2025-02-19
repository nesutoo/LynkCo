import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // Impor modul path

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/firebase.js',
                'resources/js/register.js',
                'resources/js/login.js',
                'resources/js/logout.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'), // Alias untuk memudahkan impor
        },
    },
});