<template>
  <div class="container">
    <div class="row social-links-container">
      <ShareNetwork
        network="twitter"
        url="https://news.vuejs.org/issues/180"
        title="Check out this cringey tweet"
        description="A place to share cringey shit idk"
        quote="The hot reload is so fast it\'s near instant. - Evan You"
        hashtags="cringetweets"
        twitterUser="cringetweetbot"
      >
        <i class="fab fah fa-lg fa-twitter"></i>
        <span>Share</span>
      </ShareNetwork>

      <ShareNetwork
        network="facebook"
        url="https://news.vuejs.org/issues/180"
        title="Say hi to Vite! A brand new, extremely fast development setup for Vue."
        description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
        quote="The hot reload is so fast it\'s near instant. - Evan You"
        hashtags="vuejs,vite"
      >
        <i class="fab fah fa-lg fa-facebook"></i>
        <span>Share</span>
      </ShareNetwork>
     <div style="border:1px solid red; margin-left:3px;"></div>
     <input type="text" style="padding-left:10px;" v-model="url">
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      url: 'https://news.vuejs.org/issues/180',
    }
  }
};
</script>
