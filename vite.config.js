import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                 'resources/js/app.js',
                 'resources/css/formulario.css',
                 'resources/css/mascotas.css',
                 'resources/css/servicios.css',
                 'resources/css/citas.css'
                ],
            refresh: true,
        }),
    ],
    server: {
        watch:{
            usePolling: true
        }
    }
});
