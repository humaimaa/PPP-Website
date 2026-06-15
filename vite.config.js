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
                'resources/js/turn.js',
                'resources/js/kp-map.js',
                'resources/js/admin.js',
<<<<<<< HEAD
                'resources/js/home-animate.js',
                'resources/css/home-animate.css',
=======

>>>>>>> 3970058831f00f9352a2b21bd066d4e20348fac7
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