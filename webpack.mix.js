const mix = require('laravel-mix');

mix
    .setPublicPath('dist')
    .js('resources/js/tool.js', 'js').vue()
    .sass('resources/sass/site/visitors.scss', 'css');

if (mix.inProduction()) {
    mix.version();
}
