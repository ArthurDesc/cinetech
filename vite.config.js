import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            // Spécifier le chemin public
            publicDirectory: '../public_html/cinetech',
            buildDirectory: 'build',
        }),
    ],
    build: {
        // Génère les assets dans le bon dossier
        outDir: '../public_html/cinetech/build',
        // Assure que les assets sont servis depuis le bon chemin en production
        base: '/cinetech/build/',
        // Options de build pour la production
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
