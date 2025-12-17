const mix = require('laravel-mix');
const path = require('path');

// Tambahkan ini untuk memaksa root path ke folder proyek
mix.setPublicPath('public');

mix.js(path.resolve(__dirname, 'resources/js/app.js'), 'public/js')
   .postCss(path.resolve(__dirname, 'resources/css/app.css'), 'public/css', [
        // plugins jika ada
   ]);
