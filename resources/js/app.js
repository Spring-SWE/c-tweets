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
import Vuex from 'vuex'
import { routes } from './routes';
import { noConflict } from 'lodash';

Vue.use(VueRouter)
Vue.use(Vuex);

/**
 * vuex store
 */

const store = new Vuex.Store({
    state: {
        storage: {
            voteData: []
        },
    },

    getters: {
        getVoteData: state => {
            return state.storage.voteData
        }
    },

    mutations: {
        createVoteData(state, payload) {
            state.storage.voteData.push(payload.voteData);
            localStorage.setItem('voteData', JSON.stringify(state.storage.voteData));
        },

        updateVoteData(state, payload) {
            let needsNewObject = true;
            let matchedIndex = null;
            let voteData = state.storage.voteData;

            //Check if they've voted on this tweet
            voteData.forEach((item, index) => {
                if (item.tweet_id === payload.voteData.tweet_id) {
                    matchedIndex = index;
                    needsNewObject = false;
                }
            })
            //Have not voted, create new obj
            if (needsNewObject === true) {
                state.storage.voteData.push(payload.voteData);
                localStorage.setItem('voteData', JSON.stringify(state.storage.voteData));
            //Have voted, update old entry.
            } else {
                state.storage.voteData[matchedIndex].vote = payload.voteData.vote;
                localStorage.setItem('voteData', JSON.stringify(state.storage.voteData));

            }

        },
    }
});

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
