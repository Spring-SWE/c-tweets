<template>
  <div>
    <div class="container my-3">
      <div class="row">
        <div class="col-8 card">
          <p>
            submitted by:
            <a v-bind:href="'https://twitter.com/' + tweet.original_submitter"
              >@{{ tweet.original_submitter }}</a
            >
          </p>
          <div class="row">
            <div class="col-12">
              <img
                v-bind:src="tweet.status_profile_image"
                class="rounded-circle img-fluid"
                alt=""
              />
              <span
                style="color:black; font-weight-bold; font-size:16px; position:relative; bottom:10px; left:7px; white-space: nowrap;"
                >{{ tweet.status_display_name }}</span
              >
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
              <p
                v-bind:id="'test' + tweet.id"
                style="color: #0f1419; font-size: 20px; line-height: 1.4"
              >
                {{ removedHashtagAndLinks }}
              </p>
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

          <div
            class="row py-2 my-3 text-center"
            style="border-top: 1px solid rgba(0, 0, 0, 0.125)"
          >
            <!-- <div class="col-"><i style="font-size: 22.5px;" class="far fa-comment"></i> </div> -->
            <div class="col-6">
              <i style="font-size: 22.5px" class="fas fa-retweet"></i>
              <span style="position: relative; bottom: 3px">{{
                kFormatter(tweet.status_retweet_count)
              }}</span>
            </div>
            <div class="col-6">
              <i style="font-size: 22.5px" class="far fa-heart"> </i>
              <span style="position: relative; bottom: 3px">{{
                kFormatter(tweet.status_favorite_count)
              }}</span>
            </div>
          </div>

          <!-- <div class="row">
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                        <div class="col-3">img</div>
                    </div> -->
        </div>
        <div class="vote_area">

        </div>
        <div class="col-2 d-flex vote-area" >
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
                style="color:black; font-size: 15px; padding-left: 8px"
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
      tweetWeight: this.tweet.weight,
      voteDirection: null,
    };
  },

  props: {
    tweet: Object,
  },

  created() {
    if (this.tweet.votes.length > 0) {
      this.voteDirection = this.tweet.votes[0].vote;
    }
  },

  computed: {
    removedHashtagAndLinks: function () {
      var links = this.tweet.status_text.replace(
        /(?:https?|ftp):\/\/[\n\S]+/g,
        ""
      );
      var hashtags = links.replace(/(#[^\s]*)/g, "");
      return hashtags;
    },
  },

  methods: {
    vote: function(direction) {
         axios
        .get(`/api/vote/${this.tweet.id}/${direction}`)
        .then(({ data }) => {

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
        })
        .catch(function (error) {
          alert("Take a screen shot and send this to me." + error);
          console.log(error);
        });
    },

    kFormatter: function (num) {
      return Math.abs(num) > 999
        ? Math.sign(num) * (Math.abs(num) / 1000).toFixed(1) + "k"
        : Math.sign(num) * Math.abs(num);
    },
  },

};
</script>
