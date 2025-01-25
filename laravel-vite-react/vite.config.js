import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    server: {
        https: {
            key: 'C:/laragon/etc/ssl/laragon.key', // Đường dẫn tới file key
            cert: 'C:/laragon/etc/ssl/laragon.crt', // Đường dẫn tới file cert
        },
        host: 'frontend.local.com', // Tên miền frontend của bạn
        port: 8443
    },
});
