<template>
  <div>
    <div class="container my-3">
        <div class="row">
            <div class="col-8 card">
                   <div class="row mt-3">
                        <div class="col-6">
                            <img v-bind:src="tweet.status_profile_image" class="rounded-circle img-fluid" alt="">
                            <span style="color:black; font-weight-bold; font-size:16px; position:relative; bottom:10px; left:7px;">{{ tweet.display_name }}</span>
                            <span style="position:absolute; top:17px; left:73px; color:#778998; font-size:13px;">@{{tweet.status_username}}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-1 text-center">
                            <p v-bind:id="'test'+tweet.id" style="color:#0f1419; font-size:20px; line-height:1.4;">{{ hashtag(tweet.status_text) }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <img class="w-100 img-fluid rounded"  alt="" v-bind:src="tweet.status_media_url">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">11:39 PM · May 3, 2021</div>
                    </div>

                    <div class="row py-2 text-center my-3" style="border-top:1px solid rgba(0, 0, 0, 0.125)">
                        <div class="col-4"><i style="font-size: 22.5px;" class="far fa-comment"></i> 555</div>
                        <div class="col-4"><i style="font-size: 22.5px;" class="fas fa-retweet"></i> {{tweet.status_retweet_count}}</div>
                        <div class="col-4"><i style="font-size: 22.5px;" class="far fa-heart"> </i> {{tweet.status_favorite_count}}</div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                    </div> -->
            </div>
            <div class="col-2 d-flex">
                <div class="align-self-center ml-3">
                    <div class="row py-1">
                        <a href=""></a><i class="fas fa-arrow-up" style="font-size:30px"></i>
                    </div>

                    <div class="row">
                        <span class="font-weight-bold" style="color:black;">500</span>
                    </div>

                    <div class="row py-1">
                        <i class="fas fa-arrow-down" style="font-size:30px"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

export default {
    props: {
        tweet: Object
    },

    methods: {
        hashtag: function(text){
           var repl = text.replace(/(?:https?|ftp):\/\/[\n\S]+/g, '');
           var repl = repl.replace(/(#[^\s]*)/g, '');
           return repl;
        }
    },
}
</script>
