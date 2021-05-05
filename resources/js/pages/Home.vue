<template>
  <div>
    <h3>Hottest cringe</h3>
    <hr />
    <div class="tweets">
      <tweets
        v-for="tweet in tweets"
        v-bind:key="tweet.id"
        v-bind:tweet="tweet"
      ></tweets>
    </div>
  </div>
</template>

<script>
import Tweets from "../components/Tweets.vue";

export default {
  components: { Tweets },

  data() {
    return {
      tweets: Array,
    };
  },
  methods: {
    fetchHotTweets() {
      axios
        .get("/api/tweets/latest")
        .then((response) => {
          this.tweets = response.data.data;
        })
        .catch((err) => console.error(err));
    },
  },

  created() {
    this.fetchHotTweets();
  },
};
</script>
