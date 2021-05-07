<?php

namespace App\Http\Controllers\Api;

use App\Models\Vote;
use App\Http\Controllers\Controller;

class VoteController extends Controller
{
     /**
     * Handle voting logic.
     *
     * @param $id - ID of the Tweet
     * @param $direction - Direction the user is voting, up or down
     *
     * @return not sure yet
     */
    public function vote($id, $direction) {

        $vote = Vote::firstOrCreate([
            //todo
        ]);
    }
}
