/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import NProgress from 'nprogress';
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './layouts/App'
import Hello from './pages/Hello'
import Home from './pages/Home'
import About from './pages/About'
import NotFound from './pages/NotFound'




const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        },

        {
            path: '*',
            name:'notFound',
            component: NotFound
        }
    ],
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
    router,
});
