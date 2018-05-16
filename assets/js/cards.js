/*
 * Vue test
 */
import Vue from 'vue';
import Dashboard from './Component/Dashboard';

Vue.config.debug = true;
Vue.config.devtools = true;

/**
 * Create a fresh Vue Application instance
 */
var app = new Vue({
    el: '#app',
    template: '<dashboard></dashboard>',
    components: {Dashboard}
});
