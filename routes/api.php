<?php
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

//Moved to Job see: App\Jobs\ProcessTweets.php
//Route::get('botmentions', 'App\Http\Controllers\Api\TwitterController@index');

Route::get('tweets/hot', 'App\Http\Controllers\Api\TweetController@hot');
Route::get('tweets/latest', 'App\Http\Controllers\Api\TweetController@latest');
Route::get('tweets/show/{tweet_id}', 'App\Http\Controllers\Api\TweetController@show');
Route::get('tweets/search/{query}', 'App\Http\Controllers\Api\TweetController@search');
Route::get('tweets/test', 'App\Http\Controllers\Api\TweetController@test');
Route::get('vote/{tweet_id}/{direction}', 'App\Http\Controllers\Api\VoteController@vote');



