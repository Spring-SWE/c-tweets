import Vue from 'vue'
import Vuex from 'vuex'

/**
 * vuex store
 */

Vue.use(Vuex)

export default new Vuex.Store({
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
