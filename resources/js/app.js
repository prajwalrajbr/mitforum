require('./bootstrap');

window.Vue = require('vue');
import Vuetify from '../plugins/vuetify';

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
});
