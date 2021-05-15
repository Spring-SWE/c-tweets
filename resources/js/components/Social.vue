<template>
  <div class="container">
    <div class="row social-links-container">
      <ShareNetwork
        network="twitter"
        :url=url
        title="Check out this cringy tweet"
        description="Cringetweet - A website to share and vote on the cringest tweets found on the web."
        hashtags="cringetweets"
        twitterUser="cringetweetbot"
      >
        <i class="fab fah fa-lg fa-twitter"></i>
        <span>Share</span>
      </ShareNetwork>

      <ShareNetwork
        network="facebook"
        :url=url
        title="Check out this cringy tweet"
        description="Cringetweet - A website to share and vote on the cringest tweets found on the web."
        hashtags="cringetweets,cringe"
      >
        <i class="fab fah fa-lg fa-facebook"></i>
        <span>Share</span>
      </ShareNetwork>
     <div ></div>
     <input type="text" class="ml-2" style="padding-left:10px;" v-model="url">
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      url: `cringetweets.com/show/${this.tweet_id}`,
    }
  },

  props: {
    tweet_id: Number,
  },

  created() {
      console.log(this.tweet_id)
  }
};
</script>
