import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/pitchbook.css',
                'resources/js/home-animate.js',
                'resources/js/kp-map.js',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/home-animate.css',
                'resources/js/hash.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});