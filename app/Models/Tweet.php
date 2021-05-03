<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    //Add weight, testing git.
    public function addWeight(){
        return true;
    }
}
