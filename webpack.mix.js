let mix = require('laravel-mix');

require('dotenv').config();

mix

    /**********************************
     * Scripts
     */
    .js('resources/assets/js/app.js', 'public/assets/js')
    .scripts([
        'public/assets/js/app.js'
    ], 'public/assets/js/all.js')


    /**********************************
     * Extract large libraries
     */
    .extract([
        'vue',
        'lodash',
        'jquery',
        'axios'
    ])


    /**********************************
     * Styles
     */
    .sass('resources/assets/sass/app.scss', 'public/assets/css')
    .styles([
        'public/assets/css/app.css'
    ], 'public/assets/css/all.css')


    /**********************************
     * Miscellaneous Configurations
     */
    .sourceMaps()
    .browserSync({
        files: [
            'public/assets/css/*.css',
            'public/assets/js/**/*.js',
            'resources/**/*.scss',
            'resources/views/**/*.blade.php',
            'resources/views/**/*.php',
            'app/**/*.php',
        ],
        proxy: process.env.APP_URL
    })
    .version();
