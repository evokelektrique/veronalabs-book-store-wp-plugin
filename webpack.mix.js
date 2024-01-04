const mix = require("laravel-mix");
// const { PurgeCSSPlugin } = require("purgecss-webpack-plugin");
// const purgecssWordpress = require("purgecss-with-wordpress");
// const glob = require("glob-all");
// const path = require("path");

// Configuration
mix.setPublicPath("public/");
mix.setResourceRoot("../");

// User
mix.js("assets/scripts/app.js", "public/js");
mix.sass("assets/scss/app.scss", "public/css");

// Admin
mix.js('assets/scripts/admin.js', 'public/js')
mix.sass('assets/scss/admin.scss', 'public/css')

// mix.webpackConfig({
//    plugins: [
//       new PurgeCSSPlugin({
//          paths: glob.sync(
//             [
//                `${path.join(__dirname)}/**/*`,
//                `${path.join(__dirname)}/public/**/*`,
//             ],
//             { nodir: true }
//          ),
//          safelist: purgecssWordpress.safelist,
//       }),
//    ],
// });
