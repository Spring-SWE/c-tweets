<template>
  <div>
    <h3>
      <i class="fas fa-fire fire"></i> <span class="ml-1">Search results for user @{{ query }}</span>
    </h3>
    <hr />
    <div class="tweets">
      <tweets
        v-for="tweet in tweets"
        v-bind:key="tweet.id"
        v-bind:tweet="tweet"
      ></tweets>
      <infinite-loading @infinite="infiniteHandler">
        <div slot="no-more"></div>
        <div slot="no-results">No tweets found</div>
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
      query: this.$route.query.query
    };
  },
  methods: {
    infiniteHandler($state) {
      axios
        .get(`/api/tweets/search/${this.$route.query.query}`)
        .then(({ data }) => {
          if (data.meta.total >= this.tweets.length + 1) {
            this.page += 1;
            this.tweets.push(...data.data);
            $state.loaded();
          } else {
            $state.complete();
          }
        });
    },
  }
};
</script>
