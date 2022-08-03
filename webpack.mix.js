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

//  auth.js
mix.scripts([
            'public/assets/js/jquery.min.js',
            'public/assets/plugins/bootstrap/js/popper.min.js',
            'public/assets/plugins/bootstrap/js/bootstrap.min.js',
            'public/assets/js/jquery.sparkline.min.js',
            'public/assets/js/circle-progress.min.js',
            'public/assets/plugins/p-scroll/perfect-scrollbar.js',
            'public/assets/plugins/input-mask/jquery.mask.min.js',
            'public/assets/js/custom.js',
        ],
        'public/js/auth.js')
    .sourceMaps()
    .disableNotifications()

// main.js
mix.scripts([
            'public/assets/js/jquery.min.js',
            'public/assets/plugins/bootstrap/js/popper.min.js',
            'public/assets/plugins/bootstrap/js/bootstrap.min.js',
            'public/assets/js/jquery.sparkline.min.js',
            'public/assets/js/circle-progress.min.js',
            'public/assets/plugins/input-mask/jquery.mask.min.js',
            'public/assets/plugins/horizontal-menu/horizontal-menu.js',
            'public/assets/js/stiky.js',
            'public/assets/plugins/sidebar/sidebar.js',
            'public/assets/js/custom.js',
            'public/assets/switcher/js/switcher.js',
            'public/assets/plugins/select2/select2.full.min.js',
            'public/assets/plugins/date-picker/date-picker.js',
            'public/assets/plugins/date-picker/jquery-ui.js',
        ],
        'public/js/main.js')
    .sourceMaps()
    .disableNotifications()



// auth.css
mix.styles([
            'public/assets/plugins/bootstrap/css/bootstrap.min.css',
            // 'public/assets/css/style.css',
            'public/assets/css/dark-style.css',
            'public/assets/css/skin-modes.css',
            'public/assets/plugins/single-page/css/main.css',
            'public/assets/plugins/charts-c3/c3-chart.css',
            'public/assets/plugins/p-scroll/perfect-scrollbar.css',
            'public/assets/css/icons.css',
            'public/assets/plugins/sidebar/sidebar.css',
            'public/assets/colors/color1.css',

        ],
        'public/css/auth.css')
    .sourceMaps()
    .disableNotifications();

// main.css
mix.styles([
            'public/assets/plugins/bootstrap/css/bootstrap.min.css',

            // 'public/assets/css/style.css',
            'public/assets/css/dark-style.css',
            'public/assets/css/skin-modes.css',

            'public/assets/plugins/single-page/css/main.css',

            'public/assets/plugins/charts-c3/c3-chart.css',

            'public/assets/plugins/p-scroll/perfect-scrollbar.css',

            'public/assets/css/icons.css',

            'public/assets/plugins/sidebar/sidebar.css',

            'public/assets/switcher/css/switcher.css',
            'public/assets/switcher/demo.css',

            'public/assets/plugins/select2/select2.min.css',
            'public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',

            'public/assets/plugins/select2/select2.full.min.js',
            'public/assets/plugins/date-picker/date-picker.js',
            'public/assets/plugins/date-picker/jquery-ui.js',

        ],
        'public/css/main.css')
    .sourceMaps()
    .disableNotifications();


// app.css app.js
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .disableNotifications();