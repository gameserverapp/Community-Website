let mix  = require('laravel-mix');

var browserify = require('browserify');
var fs = require('fs');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


// mix.copy('./resources/assets/js/app.js', './public/build/js/app.js');

var b = browserify();
b.add('./resources/assets/js/app.js');
b.bundle().pipe(fs.createWriteStream('./public/js/app.js'));

mix.scripts([
    './public/js/app.js',
    './node_modules/moment/moment.js',
    './node_modules/fullcalendar/dist/fullcalendar.js',
], './public/js/bundle.js').version();


mix.sass('resources/assets/sass/style.scss', 'build/css')
    .combine([
            'node_modules/fullcalendar/dist/fullcalendar.css',
            'node_modules/bootstrap/dist/css/bootstrap.css',
            'node_modules/simplemde/dist/simplemde.min.css',
            'resources/assets/vendor/owl.carousel/owl-carousel/owl.carousel.css',
            'resources/assets/vendor/owl.carousel/owl-carousel/owl.theme.css',
            'resources/assets/vendor/owl.carousel/owl-carousel/owl.transitions.css',
            'public/build/css/style.css',
    ], 'public/css/style.css')
    .version();


mix.copy('node_modules/bootstrap/fonts', 'public/build/fonts')
    .copy('resources/assets/vendor/owl.carousel/owl-carousel/*.gif', 'public/build/css/AjaxLoader.gif');
