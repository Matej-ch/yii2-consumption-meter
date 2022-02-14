let mix = require('laravel-mix');

mix.css('src/web/css/main.css', 'src/web/css/main.min.css');

mix.css('src/web/css/tui-date-picker.css', 'src/web/css/tui-date-picker.min.css');

mix.css('src/web/css/tui-time-picker.css', 'src/web/css/tui-time-picker.min.css');

mix.css('src/web/css/calendar.css', 'src/web/css/calendar.min.css');


mix.options({
    terser: {
        extractComments: false,
    },
    processCssUrls: false,
})

mix.webpackConfig({
    optimization: {
        providedExports: false,
        sideEffects: false,
        usedExports: false
    },
});