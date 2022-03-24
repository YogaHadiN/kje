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

    mix.js('resources/js/app.js', 'public/js');
    mix.styles([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/bootstrap-select.min.css',
        // 'resources/assets/css/plugins/dataTables/dataTables.bootstrap.css',
        // 'resources/assets/css/plugins/dataTables/dataTables.responsive.css',
        // 'resources/assets/css/plugins/dataTables/dataTables.tableTools.min.css',
		//'animate.css',
        'resources/assets/css/style.css',
        'resources/assets/css/jquery-ui.min.css',
    ], './public/css/all.css')
    .scripts([
        'resources/assets/js/jquery-2.1.1.js',
        'resources/assets/js/bootstrap.min.js',
        'resources/assets/js/plugins/metisMenu/jquery.metisMenu.js',
        'resources/assets/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'resources/assets/js/plugins/jeditable/jquery.jeditable.js',
        'resources/assets/js/autoNumeric.min.js',
        'resources/assets/js/bootstrap-select.min.js',
        // 'resources/assets/js/plugins/dataTables/jquery.dataTables.min.js',
        // 'resources/assets/js/plugins/dataTables/dataTables.bootstrap.min.js',
        // 'resources/assets/js/plugins/dataTables/dataTables.responsive.min.js',
        'resources/assets/js/inspinia.js',
        'resources/assets/js/plugins/pace/pace.min.js',
    ], './public/js/all.js')
    .scripts([
        'resources/assets/js/poli.js',
        'resources/assets/js/fotozoom.js',
        'resources/assets/js/togglepanel.js',
        'resources/assets/js/resepjson.js',
        'resources/assets/js/informasi_obat.js',
        'resources/assets/js/riwobs.js',
        'resources/assets/js/uk.js'
    ], './public/js/allpoli.js');
