<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieActor extends Model
{
    protected $table = 'movie_actors';
    protected $fillable = ['movie_id', 'actor_id'];
    public $timestamps = false;

}