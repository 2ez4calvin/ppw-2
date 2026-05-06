import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

//Configuração do Vite para o Laravel, incluindo o servidor de desenvolvimento e os plugins necessários para compilar os arquivos CSS e JS do projeto.
export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: { host: 'localhost' },
        watch: {
            usePolling: true,
            interval: 300,
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
})