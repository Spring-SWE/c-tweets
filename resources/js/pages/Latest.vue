<template>
  <div>
    <h3><i style="color:#f8b739;" class="fas fa-bolt"></i>  <span class="ml-1">Latest Submissions</span> </h3>
     <small>*Updated every minute</small>
    <hr />
    <div class="tweets">
      <tweets
        v-for="tweet in tweets"
        v-bind:key="tweet.id"
        v-bind:tweet="tweet"
      ></tweets>
      <infinite-loading @infinite="infiniteHandler">
            <div slot="no-more"></div>
            <div slot="no-results">No tweets found, did something go wrong?</div>
      </infinite-loading>
    </div>
  </div>
</template>

<script>
import Tweets from "../components/Tweets.vue";
import InfiniteLoading from "vue-infinite-loading";

export default {
  components: { Tweets, InfiniteLoading },

  data() {
    return {
      page: 1,
      tweets: [],
    };
  },
  methods: {
    infiniteHandler($state) {
      axios.get("/api/tweets/latest", {
        params: {
          page: this.page,
        },
      }).then(({ data }) => {
        //-1 because array counts from 0 and im too lazy to find a cleaner solution for now.ß
        if (data.meta.total >= this.tweets.length + 1) {
          this.page += 1;
          this.tweets.push(...data.data);
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    },
  },
};
</script>
