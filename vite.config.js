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
                'resources/js/pitchbook.js',
                'resources/js/home-animate.js',
                'resources/js/turn.min.js',
                'resources/js/kp-map.js',
                'resources/js/admin.js',
                'resources/css/home-animate.css',
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
    optimizeDeps: {
        include: ['jquery'],
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['jquery'],
                },
            },
        },
    },
});