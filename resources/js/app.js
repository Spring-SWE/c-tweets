/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import App from './layouts/App'
import NProgress from 'nprogress';
import Vue from 'vue'
import VueRouter from 'vue-router'
import { routes } from './routes';
import store from '../store/index'
import VueSocialSharing from 'vue-social-sharing'


Vue.use(VueSocialSharing);
Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        // Start the route progress bar.
        NProgress.start()
    }
    next()
})

router.afterEach((to, from) => {
    // Complete the animation of the route progress bar.
    NProgress.done()
})

const app = new Vue({
    el: '#app',
    components: { App },
    store,
    router,
});
