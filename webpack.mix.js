const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.combine([
    'resources/js/app.js',
], 'public/assets/js/app.js').version();

mix.combine([
    'resources/css/app.css',
], 'public/assets/css/app.css').version();

 mix.combine([
    'resources/js/cabinet.js',
], 'public/assets/js/cabinet.js').version();

mix.combine([
    'resources/css/cabinet.css',
], 'public/assets/css/cabinet.css').version();

mix.combine([
    'resources/js/appVisit.js',
], 'public/assets/js/appVisit.js').version();

mix.combine([
    'resources/css/appVisit.css',
], 'public/assets/css/appVisit.css').version();