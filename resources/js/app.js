require('./bootstrap');

window.Vue = require('vue');
import Vuetify from '../plugins/vuetify';
import VueRouter from 'vue-router';
import routes from './routes';


Vue.use(VueRouter);

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router: new VueRouter(routes)
});
