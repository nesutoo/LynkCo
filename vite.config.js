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
                'resources/js/dashboard.js',
                'resources/js/services/presenceService.js',
                'resources/js/services/kehadiranService.js',
                'resources/js/pages/documents.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'), // Alias untuk memudahkan impor
        },
    },
    define: {
        'process.env': {
            FIREBASE_API_KEY: JSON.stringify(process.env.FIREBASE_API_KEY),
            FIREBASE_AUTH_DOMAIN: JSON.stringify(process.env.FIREBASE_AUTH_DOMAIN),
            FIREBASE_PROJECT_ID: JSON.stringify(process.env.FIREBASE_PROJECT_ID),
            FIREBASE_STORAGE_BUCKET: JSON.stringify(process.env.FIREBASE_STORAGE_BUCKET),
            FIREBASE_MESSAGING_SENDER_ID: JSON.stringify(process.env.FIREBASE_MESSAGING_SENDER_ID),
            FIREBASE_APP_ID: JSON.stringify(process.env.FIREBASE_APP_ID),
        }
    }
});


