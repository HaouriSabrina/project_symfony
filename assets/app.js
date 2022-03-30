/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
// import './bootstrap';

const $ = require('jquery'); // Pour utiliser jQuery
global.$ = global.jQuery = $; // fiw un problème d'utilisation de la variable $

require('bootstrap'); // Pour utiliser le js de bootstrap