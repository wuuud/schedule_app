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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/calendar.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ]);

// バンドラーの設定
// Sail npm run hotで適宜run devしてくれる
// Hot Module Replacementの設定
mix.webpackConfig({
    devServer: {
        host: "0.0.0.0",
        port: 8080,
    },
});
if (mix.inProduction()) {
    mix.version();
}
