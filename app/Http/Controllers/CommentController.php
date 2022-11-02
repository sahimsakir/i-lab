<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\NewComment;
use App\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'web',
            'auth',
            'isActive',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \App\Comment|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function store(Request $request)
    {
        $idea = Idea::whereUuid($request->get('idea_id'))->firstOrFail();

        $comment = $idea->comments()->create([
            'idea_id' => $idea->id,
            'user_id' => auth()->id(),
            'comment' => $request->get('comment'),
        ]);

        $comment = Comment::with('user', 'idea')->whereId($comment->id)->first();

        broadcast(new NewComment($comment))->toOthers();

        $idea->is_read = false;
        $idea->update();

        return $comment;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $comment_id = $request->comment_id;

        $comment = Comment::find($comment_id);
        $comment->delete();

        broadcast(new NewComment($comment))->toOthers();

        return response(null, 204);
    }

    public function edit(Request $request)
    {
        $comment_id = $request->comment_id;

        $comment = Comment::find($comment_id);
        // $comment->delete();

        broadcast(new NewComment($comment))->toOthers();

        return $comment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $comment = Comment::find($request->comment_id);
        $comment->comment = $request->comment;
        $comment->save();

        return response("Comment Updated", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
