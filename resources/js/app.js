import BootstrapVue from "bootstrap-vue"
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vue from 'vue';
import vueMoment from "vue-moment";
import VModal from 'vue-js-modal'
import VueYoutube from 'vue-youtube'
import VueRouter from 'vue-router';
import router from './router'
import VueClipboard from 'vue-clipboard2'
import VueSocialSharing from 'vue-social-sharing'


require('./bootstrap');


window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(vueMoment);
Vue.use(VModal);
Vue.use(VueYoutube);
Vue.use(VueClipboard)
Vue.use(VueSocialSharing);

Vue.component('buttongroup', require('./components/ButtonGroup.vue').default );

const app = new Vue({
    el: '#app',
    BootstrapVue,
    router,
});;