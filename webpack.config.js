var Encore = require('@symfony/webpack-encore');
const GoogleFontsPlugin = require("google-fonts-webpack-plugin");

// noinspection JSUnresolvedFunction

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
    .cleanupOutputBeforeBuild()

    /*
     * For production, enable source maps
     */
    .enableSourceMaps(!Encore.isProduction())

    /*
     * Enable versioning - each filename will now include a hash,
     * that changes whenever the contents of that file change.
     *
     * uncomment to create hashed filename's (e.g. app.abc123.css)
     */
    // .enableVersioning(Encore.isProduction())

    /*
     * Will create public/build/app.js and public/build/app.css
     */
    .addEntry('js/cards', './assets/js/cards.js')
    .addStyleEntry('css/styles', './assets/scss/styles.scss')
    .addEntry('images/cards-logo.svg', './assets/svg/cards-logo.svg')
    .addEntry('images/cards-logo-white.svg', './assets/svg/cards-logo-white.svg')

    /*
     * Enable loader for Vue.js
     */
    .enableVueLoader()

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

    /*
     * This plugin download the Google Fonts
     */
    .addPlugin(
        new GoogleFontsPlugin({
            fonts: [
                { family: "Merienda One" }
            ],
            path: 'fonts/'
        })
    )
;

// noinspection JSUnresolvedFunction

module.exports = Encore.getWebpackConfig();
