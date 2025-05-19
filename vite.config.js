import { defineConfig } from 'vitest/config';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            // refresh: true,
        }),
    ],
    server: {
        hmr: false,
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources', import.meta.url))
        }
    },
    test: {
        globals: true,
        environment: 'jsdom',
    },
});
