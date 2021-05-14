<template>
  <div>
    <h3>
      <i class="fas fa-share"></i>
      <span class="ml-1">Share and comment on this tweet</span>
    </h3>
    <small>* commenting has not been implemented yet.</small>
    <hr />
    <div class="container">

      <social></social>
    </div>

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
import Social from '../components/Social.vue';

export default {
  components: { Tweets, Social },

  data() {
    return {
      tweets: [],
    };
  },
  created() {
    axios
      .get(`/api/tweets/show/${this.$route.params.id}`)
      .then(({ data }) => {
        this.tweets.push(data);
      })
      .catch(function (error) {
        alert("Take a screen shot and send this to me." + error);
      });
  },
};
</script>
