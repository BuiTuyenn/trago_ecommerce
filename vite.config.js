import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                        'resources/css/pages/categories/books.css',
                        'resources/js/pages/categories/books.js',
                        'resources/css/pages/categories/home-living.css',
                        'resources/js/pages/categories/home-living.js',
                        'resources/css/components/pagination/pagination.css',
                        'resources/css/components/sidebar/sidebar.css',
                        'resources/js/components/sidebar/sidebar.js'
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
