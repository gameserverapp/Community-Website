var elixir = require('laravel-elixir');
require('laravel-elixir-livereload');

var inProduction = elixir.config.production;

if( inProduction )
{
    process.env.DISABLE_NOTIFIER = true;
}

elixir(function(mix)
{

    mix.browserify('app.js');
    mix.sass('style.scss');

    mix.styles([
            './../../node_modules/bootstrap/dist/css/bootstrap.css',
            './../../node_modules/simplemde/dist/simplemde.min.css',
            './../../resources/assets/vendor/owl.carousel/owl-carousel/owl.carousel.css',
            './../../resources/assets/vendor/owl.carousel/owl-carousel/owl.theme.css',
            './../../resources/assets/vendor/owl.carousel/owl-carousel/owl.transitions.css',
            'app.css'
        ],
        null,
        'public/css');

    mix.copy(
        'node_modules/bootstrap/fonts', 'public/build/fonts'
    );

    mix.copy(
        'resources/assets/vendor/owl.carousel/owl-carousel/*.gif', 'public/build/css/AjaxLoader.gif'
    );

    mix.version(['public/css/all.css', 'public/js/bundle.js']);

    if( !inProduction )
    {
        mix.livereload([
            'app/**/*',
            'resources/views/**/*',
            'public/build/rev-*'
        ]);
    }
});