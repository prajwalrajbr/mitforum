require('./bootstrap');
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'

window.Vue = require('vue');
import Vuetify from '../plugins/vuetify';
import VueRouter from 'vue-router';
import routes from './routes';
import Vuelidate from 'vuelidate'
import SvgIcon from '@jamescoyle/vue-icon'
import { mdiAccount } from '@mdi/js'

Vue.use(Vuelidate);
Vue.use(VueRouter);
Vue.use(SvgIcon);
Vue.use(Vuetify, {
    iconfont: 'mdi' || 'md' 
  })

import App from "./App.vue";

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    router: new VueRouter(routes),
    components: {
        App
    }
});
