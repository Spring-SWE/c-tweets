<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $newTime = Carbon::parse($this->status_created_at)->format('g:i A . F d, Y ');
        return [
            'id' => $this->id,
            'status_created_at' => $newTime,
            'status_display_name' => $this->status_display_name,
            'status_username' => $this->status_username,
            'status_profile_image' => $this->status_profile_image,
            'original_submitter' => $this->original_submitter,
            'weight' => $this->weight,
            'status_text' => $this->status_text,
            'status_retweet_count' => $this->status_retweet_count,
            'status_favorite_count' => $this->status_favorite_count,
            'status_media_url' => $this->status_media_url,
        ];
    }
}
