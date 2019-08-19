
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import VueTextareaAutosize from 'vue-textarea-autosize'
import routes from './routes'

Vue.use(VueRouter);
Vue.use(VueTextareaAutosize)
Vue.component('pagination', require('laravel-vue-pagination'))

const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router,
});
