function csrf_token() {
    let domNode = document.querySelector('meta[name="csrf-token"]');
    if (domNode) {
        return domNode.getAttribute("content");
    }
    return null;
}

const mix = require("laravel-mix");
// const webpack = require("webpack");
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

mix.js("resources/js/app.js", "public/js")
.vue()
    .css("resources/css/main.css", "public/css")
    .sourceMaps()
    
    // .webpackConfig({
    //     plugins: [
    //         new webpack.DefinePlugin({
    //             "window.csrfToken": JSON.stringify(csrf_token()),
    //         }),
    //     ],
    // });

mix.styles(
    ["public/css/grid.min.css", "public/css/main.css"],
    "public/css/all.css"
);

