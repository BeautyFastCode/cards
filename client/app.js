
/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Vue from 'vue';
import Dashboard from './Component/Dashboard';

/**
 * Create a fresh Vue Application instance.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
Vue.config.debug = true;
Vue.config.devtools = true;

var app = new Vue({
    el: '#app',
    template: '<dashboard></dashboard>',
    components: {Dashboard}
});
