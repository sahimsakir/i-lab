<?php

namespace App;

use App\Idea;
use Illuminate\Database\Eloquent\Model;

class ShortListedIdea extends Model
{
    public function send_ideas()
    {
        return $this->hasMany('App\SendIdea','shortlist_id','id');
    }

    public function ideas()
    {
        return $this->belongsTo(Idea::class,'idea_id', 'id' );
    }
}