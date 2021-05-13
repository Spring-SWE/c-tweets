<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Tweet;
use App\Http\Resources\TweetResource;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function hot()
    {
        return TweetResource::collection(Tweet::orderBy('weight', 'desc')->orderBy('created_at', 'desc')->paginate(5));
    }

    public function latest()
    {
        return TweetResource::collection(Tweet::orderBy('created_at', 'desc')->paginate(5));
    }

    public function show(Request $request, $tweet_id)
    {
        //Creat the vote as a default 'Null' if it doesn't exist.
        //The reason for this is because the client requires a vote for voting html to work
        Vote::firstOrCreate(
            ['visitor' => $request->ip(), 'tweet_id' => $tweet_id],
            ['tweet_id' => $tweet_id, 'visitor' => $request->ip()]
        );

        //first() return OBJ, get() return collection of objects
        //TODO, pick speific fields, we don't need to use *
        return Tweet::select('tweets.*', 'votes.vote')->where('tweets.id',  $tweet_id)->joinRelationship('votes', function ($join) use ($request) {
            $join->where('votes.visitor', $request->ip());
        })->first();
    }
}
