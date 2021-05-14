<template>
  <div>
    <h3>
      <i class="fas fa-share"></i>
      <span class="ml-1">Share and comment on this tweet</span>
    </h3>
    <small>* commenting has not been implemented yet.</small>
    <hr />
    <div class="container">

      <test></test>
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
import Test from '../components/Social.vue';

export default {
  components: { Tweets, Test },

  data() {
    return {
      tweets: [],
    };
  },
  created() {
    console.log(this.$route.params);
    axios
      .get(`/api/tweets/show/${this.$route.params.id}`)
      .then(({ data }) => {
        console.log(data);
        this.tweets.push(data);
      })
      .catch(function (error) {
        alert("Take a screen shot and send this to me." + error);
      });
  },
};
</script>
