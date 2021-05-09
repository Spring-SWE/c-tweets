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

        $vote = Vote::firstOrCreate(
            ['visitor' => $request->ip(), 'tweet_id' => $tweet_id],
            ['tweet_id' => $tweet_id, 'vote' => $direction, 'visitor' => $request->ip()]
        );

        /**
         * Sloppy as hell, will refactor this soon lol
         */
        if ($direction == 1) {
            //var_dump($vote->vote);
            if ($vote->vote === 0) {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight + 1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = 1;
                $vote2->save();

                return response()->json([
                    'current_vote' => $vote2->vote,
                ]);

            } elseif ($vote->vote === 1) {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight - 1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = NULL;
                $vote2->save();

                return response()->json([
                    'current_vote' => $vote2->vote,
                ]);


            } else {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight + 1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = 1;
                $vote2->save();

               return response()->json([
                    'current_vote' => $vote2->vote,
                ]);
            }
        } elseif($direction == 0){
            if ($vote->vote === 0) {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight + 1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = NULL;
                $vote2->save();

                return response()->json([
                    'current_vote' => $vote2->vote,
                ]);

            } elseif ($vote->vote === 1) {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight - 1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = 0;
                $vote2->save();

                return response()->json([
                    'current_vote' => $vote2->vote,
                ]);
            } else {
                $tweet = Tweet::find($tweet_id);
                $tweet->weight = $tweet->weight + -1;
                $tweet->save();

                $vote2 = Vote::find($vote->id);
                $vote2->vote = 0;
                $vote2->save();

                return response()->json([
                    'current_vote' => $vote2->vote,
                ]);
            }
        } else {
            dd("no");
        }
    }
}
