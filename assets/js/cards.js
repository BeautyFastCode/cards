/*
 * Vue test
 */
import Vue from 'vue';
import Example from './Component/Example';

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
    template: '<div><p>{{ message }}</p><example></example></div>',
    components: {Example}
});

//console.log('Starting the Cards.js');
