var Encore = require('@symfony/webpack-encore');
// const GoogleFontsPlugin = require("google-fonts-webpack-plugin");

/**
 * The Encore helps generate the Webpack configuration.
 */
Encore
    /*
     * The project directory where compiled assets will be stored
     */
    .setOutputPath('public/build/')

    /*
     * The public path used by the web server to access the previous directory
     */
    .setPublicPath('/build')

    /*
     * Empty the outputPath dir before each build
     */
    // .cleanupOutputBeforeBuild() // disable for build speed

    /*
     * For production, enable source maps
     */
    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    /*
     * Will create public/build/app.js and public/build/app.css
     */
    .addEntry('js/cards', './assets/js/cards.js')
    .addStyleEntry('css/cards', './assets/scss/cards.scss')

    /*
     * Sass/SCSS
     */
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()

    /*
     * Show OS notifications when builds finish/fail
     */
    .enableBuildNotifications()

    // disable for build speed
/*    .addPlugin(
        new GoogleFontsPlugin({
            fonts: [
                { family: "Merienda One" }
            ],
            path: 'fonts/'
        })
    )*/
;

module.exports = Encore.getWebpackConfig();
