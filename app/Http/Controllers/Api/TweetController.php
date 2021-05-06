<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\TweetUser;
use App\Http\Resources\TweetResource;

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
}
