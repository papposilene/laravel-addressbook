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

mix.webpackConfig({
    stats: {
        children: true,
    },
});


mix.options({
    processCssUrls: false,
});

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('postcss-url')(
            { url: (asset) => `../img/${asset.pathname?.replace(/^.*(\\|\/|\:)/, '')}` },
        ),
        require('tailwindcss'),
    ]);

mix.copy('public/js', 'htdocs/js');
mix.copy('public/css', 'htdocs/css');
mix.copy('resources/svg', 'public/img');

if (mix.inProduction()) {
    mix.version();
}
