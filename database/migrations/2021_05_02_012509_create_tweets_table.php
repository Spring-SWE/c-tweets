<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void.
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->string('status_created_at');
            $table->string('status_id');
            $table->string('status_display_name');
            $table->string('status_username');
            $table->string('status_profile_image');
            $table->string('original_submitter');
            $table->string('status_user_id');
            $table->string('status_user_id_str');
            $table->integer('weight');
            $table->text('status_text');
            $table->string('in_reply_to_status_id_str')->nullable();
            $table->integer('status_retweet_count');
            $table->integer('status_favorite_count');
            $table->string('status_media_url')->nullable();
            $table->text('status_urls')->nullable();
            $table->string('status_parent')->nullable();
            $table->string('quoted_url')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
