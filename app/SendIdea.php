<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendIdea extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    public function ideas()
    {
        return $this->belongsTo('App\Idea', 'id', 'idea_id');
    }

    public function short_listed_idea()
    {
        return $this->belongsTo('App\ShortListedIdea', 'id', 'shortlist_id');
    }
}
