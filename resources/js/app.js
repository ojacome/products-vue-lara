require('./bootstrap');
import Vue from 'vue'
import { BootstrapVue } from 'bootstrap-vue'
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate'
import App from './vue/app.vue'
import routes from './vue/routes'


Vue.use(Vuelidate)
Vue.use(VueRouter);
Vue.use(BootstrapVue)


const router = new VueRouter({
    routes 
})

const app = new Vue({
    el: '#app',
    router,
    components: { App }
});