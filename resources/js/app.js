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
import Home from './pages/Home'
import Latest from './pages/Latest'
import About from './pages/About'
import Support from './pages/Support'
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
            path: '/latest',
            name: 'latest',
            component: Latest,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        },

        {
            path: '/support',
            name: 'support',
            component: Support,
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
