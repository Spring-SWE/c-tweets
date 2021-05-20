<?php

namespace App\Http\Controllers\Api;

use App\Models\Vote;
use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Handle voting logic.
     *
     * @param $tweet_id - ID of the Tweet
     * @param $direction - Direction the user is voting, up or down
     *
     * @return JSON response
     */
    public function vote(Request $request, $tweet_id, $direction, $token)
    {
        if ($this->verifyCaptcha($token) === true) {
            $direction = ($direction == 'down') ? 0 : (($direction == 'up') ? 1 : dd("can't do that."));

            $vote = Vote::firstOrCreate(
                ['visitor' => $request->ip(), 'tweet_id' => $tweet_id],
                ['tweet_id' => $tweet_id, 'visitor' => $request->ip()]
            );
            $tweet = Tweet::find($tweet_id);


            if ($direction == 1) {

                //Vote is 0, you vote up so 1. Vote vaule goes to 1 or 'voted up'
                if ($vote->vote === 0) {
                    $tweetWeight = $tweet->weight + 2;
                    $voteValue = 1;
                }

                //Vote is 1, you voted up so back to 'null' or 'default'
                if ($vote->vote === 1) {
                    $tweetWeight = $tweet->weight - 1;
                    $voteValue = null;
                }

                //Vote is null, you voted up so value is '1'
                if ($vote->vote === null) {
                    $tweetWeight = $tweet->weight + 1;
                    $voteValue = 1;
                }

                $this->updateVote($tweet, $vote, $tweetWeight, $voteValue);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
            } elseif ($direction == 0) {

                if ($vote->vote === 0) {

                    $tweetWeight = $tweet->weight + 1;
                    $voteValue = null;
                }

                if ($vote->vote === 1) {
                    $tweetWeight = $tweet->weight - 2;
                    $voteValue = 0;
                }

                if ($vote->vote === null) {
                    $tweetWeight = $tweet->weight - 1;
                    $voteValue = 0;
                }

                $this->updateVote($tweet, $vote, $tweetWeight, $voteValue);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
            }
        } else {
            return json_encode("errors with captcha");
        }
    }

    private function verifyCaptcha($gRecaptchaResponse)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha("6LcGZdsaAAAAALiRjMBeo7CCUmMtbpiW6VuqV1Rf");
        $resp = $recaptcha->setExpectedHostname('localhost')
            ->setScoreThreshold(0.5)
            ->verify($gRecaptchaResponse,);

        if ($resp->isSuccess()) {
            return true;
        } else {
           return $resp->getErrorCodes();
        }
    }


    private function updateVote($tweet, $vote, $weight, $voteNumber)
    {
        $tweet->weight = $weight;
        $tweet->save();
        $vote->vote = $voteNumber;
        $vote->save();
    }
}
