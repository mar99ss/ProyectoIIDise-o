const mix = require('laravel-mix');

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

mix.autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
        'popper.js/dist/umd/popper.js': ['Popper']
    })
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/welcome.scss', 'public/css')
    .sass('resources/sass/horizontal-layout.scss', 'public/css')
    .sass('resources/sass/admin.index.scss', 'public/css')
    .sass('resources/sass/miembros.scss', 'public/css')
    .sass('resources/sass/jerarquia.scss', 'public/css')
    .sass('resources/sass/edit-miembros.scss', 'public/css')
    .sass('resources/sass/asignar-grupo.scss', 'public/css')
    .sass('resources/sass/posiciones-jerarquia.scss', 'public/css')
    .sass('resources/sass/cambio-jerarquia.scss', 'public/css')
    .sass('resources/sass/ippopup.scss', 'public/css')
    .sass('resources/sass/movimientos-catalog.scss', 'public/css')
;

// mix.browserSync('http://proyectoidiseno.test/');

if (mix.inProduction())
    mix.version();
