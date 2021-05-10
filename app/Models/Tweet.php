<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
