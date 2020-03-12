const mix = require('laravel-mix');
const path = require('path');

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

mix
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.json', '.vue'],
            alias: {
                '~client': path.join(__dirname, './resources/vue-client')
            }
        },
        node: {
            fs: "empty",
            module: "empty"
        }
    })
    .js('resources/vue-client/app.js', 'public/js')
    .sass('resources/vue-client/assets/scss/styles.scss', 'public/css')
    .copy('resources/vue-client/assets/images', 'public/images')
    .version();;
