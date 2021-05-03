<template>
    <div>
         <p>This is the homepage</p>
         <tweets></tweets>
    </div>
</template>
<script>
import Tweets from '../components/Tweets.vue'

export default {
  components: { Tweets },
   props: {

   },
}
</script>
