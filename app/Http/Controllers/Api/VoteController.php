<?php

namespace App\Http\Controllers\Api;

use App\Models\Vote;
use App\Models\Tweet;
use App\Http\Controllers\Controller;
use Error;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Handle voting logic.
     *
     * @param $id - ID of the Tweet
     * @param $direction - Direction the user is voting, up or down
     *
     * @return not Resource
     */
    public function vote(Request $request, $tweet_id, $direction)
    {
        if($direction == "up") {
            $direction = 1;
        } elseif($direction == "down") {
            $direction = 0;
        } else {
            dd("not allowed");
        }

        $vote = Vote::firstOrCreate(
            ['visitor' => $request->ip(), 'tweet_id' => $tweet_id],
            ['tweet_id' => $tweet_id, 'visitor' => $request->ip()]
        );


        $tweet = Tweet::find($tweet_id);

        /**
         * Sloppy as hell, will refactor this soon lol
         */
        if ($direction == 1) {

            //Vote is 0, you vote up so 1.
            if ($vote->vote === 0) {

                $tweetWeight = $tweet->weight + 2;
                $this->updateVote($tweet, $vote, $tweetWeight, 1);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
                //Vote is 1, you vote up, so no vote, or NULL.
            } elseif ($vote->vote === 1) {
                $tweetWeight = $tweet->weight - 1;
                $this->updateVote($tweet, $vote, $tweetWeight, NULL);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
                //Vote is NULL (you haven't voted), you vote up, so 1.
            } elseif($vote->vote === null) {
                $tweetWeight = $tweet->weight + 1;
                $this->updateVote($tweet, $vote, $tweetWeight, 1);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
            }
            //Vote is currently -1, you voted down again so null
        } elseif ($direction == 0) {

            if ($vote->vote === 0) {

                $tweetWeight = $tweet->weight + 1;
                $this->updateVote($tweet, $vote, $tweetWeight, NULL);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
                //Vote is currently UP but you voted down so 0
            } elseif ($vote->vote === 1) {

                $tweetWeight = $tweet->weight - 2;
                $this->updateVote($tweet, $vote, $tweetWeight, 0);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
                //You have not voted, and vote is down so 0
            } elseif($vote->vote === null) {
                $tweetWeight = $tweet->weight - 1;

                $this->updateVote($tweet, $vote, $tweetWeight, 0);

                return response()->json([
                    'current_vote' => $vote->vote,
                    'weight' => $tweetWeight,
                ]);
            }
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
