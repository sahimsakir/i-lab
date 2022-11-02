<?php

namespace App\Http\Controllers;

use App\IdeaFeedback;
use App\SendIdea;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdeaFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $feedback = IdeaFeedback::where([
            ['idea_id', "=", $request->idea_id],
            ['user_id', '=', auth()->user()->id],
        ])->first();
        if ($feedback) {
            return $this->update($request, $feedback);
        } else {
            $feedback = new IdeaFeedback();
            $feedback->idea_id = $request->idea_id;
            $feedback->user_id = auth()->user()->id;
            $feedback->shortlist_id = $request->shortlist_id;
            $feedback->is_featured = $request->is_featured;
            $feedback->is_sponsored = $request->is_sponsored;

            $feedback->save();

            $updateSendIdea = SendIdea::where('shortlist_id',$feedback->shortlist_id)->first();
            $updateSendIdea->given_feedback = true;
            $updateSendIdea->save();

            return response()->json(['data' => $feedback], Response::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IdeaFeedback  $ideaFeedback
     * @return \Illuminate\Http\Response
     */
    public function show(IdeaFeedback $ideaFeedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IdeaFeedback  $ideaFeedback
     * @return \Illuminate\Http\Response
     */
    public function edit(IdeaFeedback $ideaFeedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IdeaFeedback  $ideaFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IdeaFeedback $ideaFeedback)
    {
        $ideaFeedback->is_featured = $request->is_featured;
        $ideaFeedback->is_sponsored = $request->is_sponsored;
        $ideaFeedback->save();
        return response()->json(['updated' => $ideaFeedback], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IdeaFeedback  $ideaFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdeaFeedback $ideaFeedback)
    {
        //
    }
}