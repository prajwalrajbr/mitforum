require('./bootstrap');
import 'material-design-icons-iconfont/dist/material-design-icons.css'

window.Vue = require('vue');
import Vuetify from '../plugins/vuetify';
import VueRouter from 'vue-router';
import routes from './routes';


Vue.use(VueRouter);

import App from "./App.vue";

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router: new VueRouter(routes),
    components: {
        App
    }
});
