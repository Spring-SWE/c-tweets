<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\TweetUser;
use App\Http\Resources\TweetResource;

class TweetController extends Controller
{
    public function latest()
    {
        return TweetResource::collection(Tweet::paginate(10));
    }

    public function hot()
    {

    }
}
