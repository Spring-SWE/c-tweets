<template>
  <div>
    <h3><i class="fas fa-fire fire"></i> <span class="ml-1">Hot Cringe</span></h3>
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
      axios.get("/api/tweets/hot", {
        params: {
          page: this.page,
        },
      }).then(({ data }) => {
          console.log(data);
          console.log(this.page);
          console.log(this.tweets);
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
