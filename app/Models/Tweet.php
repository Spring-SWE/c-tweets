<?php

namespace App\Models;

use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    use PowerJoins;

    public $timestamps = false;
    protected $guarded = [];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
