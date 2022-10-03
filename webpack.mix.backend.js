let mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

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
    jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"]
});


mix.extract(['vue', 'jquery', 'popper.js', 'bootstrap', 'lodash', 'moment', 'sweetalert2',
    'toastr', 'vuex', 'axios', 'moment-range', 'vee-validate', 'epic-spinners', 
    'vue-translate-plugin', 'bootstrap-datepicker'
]).js('resources/js/admin.js', 'public/backend/js')

mix.sass('resources/sass/admin.scss', 'public/backend/css')
.options({
    processCssUrls: false,
    imgLoaderOptions: {
        enabled: false
    },
}).mergeManifest()


if (mix.inProduction()) {
    mix.version();
}
