import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/components/pagination/pagination.css',
                'resources/css/categories/category-master.css',
                'resources/css/layouts/container-override.css'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
    },
});
