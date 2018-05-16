/*
 * Vue test
 */
import Vue from 'vue';
import Example from './Component/Example';
import Suite from './Component/Suite';

Vue.config.debug = true;
Vue.config.devtools = true;

/**
 * Create a fresh Vue Application instance
 */
var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Cards!'
    },
    template: '<div><p>{{ message }}</p><suite></suite><example></example></div>',
    components: {Example, Suite}
});

//console.log('Starting the Cards.js');
