<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Like;
use App\Operation;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \App\Like|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $like = Like::where([
            ['idea_id', $request->idea_id],
            ['user_id', $request->user()->id],
        ])->first();

        $idea = Idea::find($request->idea_id);

        if (!$like) {
            $like = Like::create([
                'idea_id' => $request->idea_id,
                'user_id' => auth()->id(),
                'is_liked' => true,
            ]);

            $idea->is_read = false;
            $idea->update();

            return $like;
        }
        if ($like->is_liked) {
            $like->update([
                'is_liked' => false,
            ]);

            $idea->is_read = false;
            $idea->update();

            return $like;
        }

        $like->update([
            'is_liked' => true,
        ]);

        $idea->is_read = false;
        $idea->update();

        // Make Featured by Likes number
        $this->makeFeaturedByLikes($request->idea_id);

        return $like;

    }



    // make featured by likes amount
    public function makeFeaturedByLikes($idea_id)
    {
       
        $likes = Operation::all();
        $number_of_likes_for_featured = $likes[0]->number_of_likes_for_featured;

        $idea = Idea::where('id',$idea_id)->with('likes')->first();
        
        // return $idea;
        if ($idea->likes->count() >= $number_of_likes_for_featured){
            $idea->is_featured = 1;
            $idea->save();
        }
    }
}
