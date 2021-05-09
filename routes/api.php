<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('botmentions', 'App\Http\Controllers\Api\TwitterController@index');


Route::get('tweets/hot', 'App\Http\Controllers\Api\TweetController@hot');
Route::get('tweets/latest', 'App\Http\Controllers\Api\TweetController@latest');
Route::get('vote/{tweet_id}/{direction}', 'App\Http\Controllers\Api\VoteController@vote');

