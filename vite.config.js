import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/filament/admin/theme.css', 'resources/css/filament/student/theme.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
