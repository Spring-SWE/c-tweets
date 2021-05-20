<template>
  <div>
    <div class="container my-3">
      <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 col-lg-8 col-xl-8 card">
          <div v-if="tweet.quoted_url != null">
            <small
              ><i class="fas fa-retweet"></i> This tweet is quoting this
              <a :href="tweet.quoted_url" target="_blank">tweet</a></small
            >
          </div>
          <p>
            submitted by:
            <a v-bind:href="'https://twitter.com/' + tweet.original_submitter"
              >@{{ tweet.original_submitter }}</a
            >
          </p>
          <div class="row">
            <div class="col-12">
              <router-link :to="{ name: 'show', params: { id } }">
                <img
                  v-bind:src="tweet.status_profile_image"
                  class="rounded-circle img-fluid"
                  alt=""
                />
                <span
                  style="color:black; font-weight-bold; font-size:16px; position:relative; bottom:10px; left:7px; white-space: nowrap;"
                  >{{ tweet.status_display_name }}</span
                >
              </router-link>
              <span
                style="
                  position: absolute;
                  top: 17px;
                  left: 73px;
                  color: #778998;
                  font-size: 13px;
                "
                ><a v-bind:href="'https://twitter.com/' + tweet.status_username"
                  >@{{ tweet.status_username }}</a
                ></span
              >
            </div>
          </div>

          <div class="row">
            <div class="col-12 mt-1 text-center">
              <span
                style="color: #0f1419; font-size: 20px; line-height: 1.4"
                v-html="removeHashtagAndCreateLinks"
              >
              </span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 text-center">
              <img
                class="w-100 img-fluid rounded"
                alt=""
                v-bind:src="tweet.status_media_url"
              />
            </div>
          </div>

          <div class="row">
            <div class="col-12">{{ tweet.status_created_at }}</div>
          </div>

          <router-link :to="{ name: 'show', params: { id } }">
            <div
              class="row py-2 my-3 text-center"
              style="border-top: 1px solid rgba(0, 0, 0, 0.125); color: #808080"
            >
              <!-- <div class="col-"><i style="font-size: 22.5px;" class="far fa-comment"></i> </div> -->
              <div class="col-3">
                <i style="font-size: 22.5px" class="fas fa-retweet"></i>
                <span style="position: relative; bottom: 3px">{{
                  kFormatter(tweet.status_retweet_count)
                }}</span>
              </div>
              <div class="col-3">
                <i style="font-size: 22.5px" class="far fa-heart"> </i>
                <span style="position: relative; bottom: 3px">{{
                  kFormatter(tweet.status_favorite_count)
                }}</span>
              </div>

              <div class="col-3">
                <i style="font-size: 22.5px" class="far fa-comment"> </i>
                <span style="position: relative; bottom: 3px">0 </span>
              </div>

              <div class="col-3">
                <i style="font-size: 22.5px" class="fas fa-share"> </i>
                <span style="position: relative; bottom: 3px">0</span>
              </div>
            </div>
          </router-link>

          <!-- <div class="row">
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                    </div> -->
        </div>
        <div
          class="col-2 d-flex vote-area justify-content-center text-center mx-auto"
          style=""
        >
          <!-- Voted Up on this Tweet  -->
          <div v-if="voteDirection === 1" class="align-self-center ml-3">
            <div class="row py-1">
              <i
                class="fas fa-arrow-up primary-darker"
                style="font-size: 30px"
                v-on:click="vote('up')"
              ></i>
            </div>

            <div class="row">
              <span
                class="font-weight-boldest"
                style="color: black; font-size: 15px; padding-left: 8px"
                >{{ kFormatter(tweetWeight) }}
              </span>
            </div>

            <div class="row py-1">
              <i
                class="fas fa-arrow-down"
                style="font-size: 30px"
                v-on:click="vote('down')"
              ></i>
            </div>
          </div>

          <!-- No vote  -->
          <div
            v-if="voteDirection == null || vote == undefined"
            class="align-self-center ml-3"
          >
            <div class="row py-1">
              <i
                class="fas fa-arrow-up"
                style="font-size: 30px"
                v-on:click="vote('up')"
              ></i>
            </div>

            <div class="row">
              <span
                class="font-weight-boldest"
                style="color: black; font-size: 15px; padding-left: 8px"
                >{{ tweetWeight }}
              </span>
            </div>

            <div class="row py-1">
              <i
                class="fas fa-arrow-down"
                style="font-size: 30px"
                v-on:click="vote('down')"
              ></i>
            </div>
          </div>

          <!-- Voted down -->
          <div v-if="voteDirection === 0" class="align-self-center ml-3">
            <div class="row py-1">
              <i
                class="fas fa-arrow-up"
                style="font-size: 30px"
                v-on:click="vote('up')"
              ></i>
            </div>

            <div class="row">
              <span
                class="font-weight-boldest"
                style="color: black; font-size: 15px; padding-left: 8px"
                >{{ tweetWeight }}
              </span>
            </div>

            <div class="row py-1">
              <i
                class="fas fa-arrow-down primary-darker"
                style="font-size: 30px"
                v-on:click="vote('down')"
              ></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      id: this.tweet.id,
      tweetWeight: this.tweet.weight,
      voteDirection: null,
    };
  },

  props: {
    tweet: Object,
  },

  created() {
    //Vote should be an Object when viewing multiple votes
    if (typeof this.tweet.vote == "object") {
      if (this.tweet.vote.length > 0) {
        this.voteDirection = this.tweet.vote[0].vote;
      }
      //Vote will be a integer when viewing a single vote
    } else {
      this.voteDirection = this.tweet.vote;
    }
  },

  computed: {
    removeHashtagAndCreateLinks: function () {
      let hashtags = this.tweet.status_text;
      return this.linkify(hashtags);
    },
  },

  methods: {
    vote: function (direction) {
      grecaptcha.ready(()=> {
        grecaptcha
          .execute("6LcGZdsaAAAAAGEKcSBAViwf9A2JUYvcMiAgJwJy", { action: "submit" })
          .then((token) => {
            axios
              .get(`/api/vote/${this.tweet.id}/${direction}/${token}`)
              .then(({ data }) => {
                if (data !== "errors with captcha") {
                  //Get the updated weight and direction
                  this.tweetWeight = data.weight;
                  this.voteDirection = data.current_vote;

                  if (localStorage.getItem("voteData") === null) {
                    //User voted, but has no previous entries, add one.
                    this.$store.commit("createVoteData", {
                      voteData: {
                        tweet_id: this.tweet.id,
                        vote: data.current_vote,
                      },
                    });
                  } else {
                    //This is not a first time vote data.
                    this.$store.commit("updateVoteData", {
                      voteData: {
                        tweet_id: this.tweet.id,
                        vote: data.current_vote,
                      },
                    });
                  }
                } else {
                  alert("spamming an API doesn't make you a hacker lol");
                }
              })
              .catch((error) => {
                alert("Take a screen shot and send this to me." + error);
              });
          });
      });
    },

    kFormatter: function (num) {
      return Math.abs(num) > 999
        ? Math.sign(num) * (Math.abs(num) / 1000).toFixed(1) + "k"
        : Math.sign(num) * Math.abs(num);
    },

    linkify: function (inputText) {
      var replacedText, replacePattern1, replacePattern2, replacePattern3;

      //URLs starting with http://, https://, or ftp://
      replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
      replacedText = inputText.replace(
        replacePattern1,
        '<a href="$1" target="_blank">$1</a>'
      );

      //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
      replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
      replacedText = replacedText.replace(
        replacePattern2,
        '$1<a href="http://$2" target="_blank">$2</a>'
      );

      //Change email addresses to mailto:: links.
      replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
      replacedText = replacedText.replace(
        replacePattern3,
        '<a href="mailto:$1">$1</a>'
      );

      return replacedText;
    },
  },
};
</script>
