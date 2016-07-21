var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'bootstrap.min.css',
        'bootstrap-select.min.css',
        'plugins/dataTables/dataTables.bootstrap.css',
        'plugins/dataTables/dataTables.responsive.css',
        'plugins/dataTables/dataTables.tableTools.min.css',
		//'animate.css',
        'style.css',
        'jquery-ui.min.css',
        'plugins/datepicker/datepicker3.css',
    ])
    .scripts([
        'jquery-2.1.1.js',
        'bootstrap.min.js',
        'plugins/metisMenu/jquery.metisMenu.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'plugins/jeditable/jquery.jeditable.js',
        'autoNumeric.js',
        'bootstrap-select.min.js',
        'plugins/datepicker/bootstrap-datepicker.js',
        'plugins/dataTables/jquery.dataTables.min.js',
        'plugins/dataTables/dataTables.bootstrap.min.js',
        'plugins/dataTables/dataTables.responsive.min.js',
        'inspinia.js',
        'plugins/pace/pace.min.js',
    ])
    .scripts([
        'poli.js',
        'fotozoom.js',
        'togglepanel.js',
        'resepjson.js',
        'informasi_obat.js',
        'riwobs.js',
        'uk.js'
    ], './public/js/allpoli.js')
    .version([
        'public/css/all.css',
        'public/js/all.js'
    ]);
});
