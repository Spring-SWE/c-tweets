<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Tweet;
use App\Models\TweetUser;
use Atymic\Twitter\Facade\Twitter;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTweets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * TODO: Add File logging instead of JSON logging.
         */
        $returnData = [];

        //Collect mentions...from people who @ bot.
        $tweets = Twitter::getMentionsTimeline(['screen_name' => 'ezbakespring', 'count' => 10, 'response_format' => 'array']);

        //Loop through the tweets that were grabbed from the TimeLine.
        foreach ($tweets as $originalTweet) {

            //User cannot submit his original tweet to the bot, that's cringe as fuck.
            if (!$originalTweet['in_reply_to_status_id_str']) {
                $this->buildJsonReturnData($returnData, "Tweeting a cringe post yourself, is cringe.", false, true, $originalTweet['user']['screen_name'], $originalTweet['id_str']);
            } else {
                //Try to run! IF any errors are found, they should be dealt with by the catch.
                try {
                    $selectedTweet = Twitter::getTweet($originalTweet['in_reply_to_status_id_str'], ['tweet_mode' => 'extended', 'response_format' => 'array']);
                    //verify that the tweet is a tweet DIRECTLY replying to PARENT Tweet
                    //no multi-level tweets yet allowed.
                    if ($selectedTweet['in_reply_to_status_id_str']) {
                        $this->buildJsonReturnData($returnData, "Multi-level replies (recursion) are not supported yet.", false, false, $originalTweet['user']['screen_name'], $selectedTweet['id_str']);
                    }
                    //This is the intended tweet, no parent found. Continue.
                    else {
                        //See if tweet already exists in database. This is because multiple people are allowed
                        //to submit the tweet. Each submission adds "weight" to the tweet.
                        if ($tweet = Tweet::where('status_id', $selectedTweet['id_str'])->first()) {
                            /**
                             * We found the tweet. This tweet exists in the database. Now we need to verify
                             * the user submitting the tweet doesn't exist. This would be ORIGINALTWEET
                             */
                            if ($tweetUser = TweetUser::where('username', $originalTweet['user']['screen_name'])->first()) {
                                //ignore -- this user has already submitted this tweet.
                                //Probably build an array of Json errors/warnings

                                $this->buildJsonReturnData($returnData, "This user has already submitted this tweet.", false, false, $originalTweet['user']['screen_name'], $selectedTweet['id_str']);
                            } else {
                                /**
                                 * User not found, add "weight" to tweet and add user for the future
                                 * and for searching purposes.
                                 */
                                $tweet->increment('weight');
                                $tweet->save();

                                $newUser = TweetUser::create([
                                    'status_id' => $selectedTweet['id_str'],
                                    'tweet_id' => $tweet->id,
                                    'username' => $originalTweet['user']['screen_name']
                                ]);

                                $this->buildJsonReturnData($returnData, "User was not found, but tweet was found, added weight.", false, true, $originalTweet['user']['screen_name'], $selectedTweet['id_str']);
                            }
                        } else {
                            /**
                             * This tweet does not exist in the database and should be created
                             * We will also need to add the original user so we can properly
                             * calculate weight.
                             */
                            $tweet = Tweet::create([
                                'status_created_at' => $selectedTweet['created_at'],
                                'status_id' => $selectedTweet['id_str'],
                                'status_display_name' => $selectedTweet['user']['name'],
                                'status_username' => $selectedTweet['user']['screen_name'],
                                'status_profile_image' => $selectedTweet['user']['profile_image_url_https'],
                                'original_submitter' => $originalTweet['user']['screen_name'],
                                'status_user_id' => $selectedTweet['user']['id'],
                                'status_user_id_str' => $selectedTweet['user']['id_str'],
                                'weight' => '0',
                                'status_text' => $selectedTweet['full_text'],
                                'in_reply_to_status_id_str' => $selectedTweet['in_reply_to_status_id_str'],
                                'status_retweet_count' => $selectedTweet['retweet_count'],
                                'status_favorite_count' => $selectedTweet['favorite_count'],
                                'status_media_url' => $selectedTweet['entities']['media']['0']['media_url_https'] ?? NULL,
                                'status_parent' => null,
                            ]);

                            //Also create the user so we don't get duplicate votes.
                            $newUser = TweetUser::create([
                                'status_id' => $selectedTweet['id_str'],
                                'tweet_id' => $tweet->id,
                                'username' => $originalTweet['user']['screen_name']
                            ]);

                            $this->buildJsonReturnData($returnData, "Tweet not found! Tweet and user added", false, true, $originalTweet['user']['screen_name'], $selectedTweet['id_str']);
                        }
                    }
                }
                //Fetch tweet had error, PROBABLY deleted.
                catch (Exception $e) {
                    $this->buildJsonReturnData($returnData, $e->getMessage(), true, false, $originalTweet['user']['screen_name'], null);
                }
            }
        }

        return $returnData;
    }

    private function buildJsonReturnData(&$array, $status, $error, $weight, $username, $selectedTweetId)
    {
        $tempArray = [
            "timestamp" => Carbon::now()->format('Y-m-d g:i A'),
            "status" => $status,
            "error" => $error,
            "add weight" => $weight,
            "username" => $username,
            'selected_tweet_id' => $selectedTweetId,
        ];

        array_push($array, $tempArray);
    }
}
