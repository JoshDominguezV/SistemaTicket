const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .browserSync({
       proxy: 'http://tu-proyecto-laravel.test', // Cambia esto por la URL de tu proyecto
       files: [
           'app/**/*.php',
           'resources/views/**/*.php',
           'public/js/**/*.js',
           'public/css/**/*.css'
       ]
   });
