<?php

namespace App\Http\Controllers;

use App\User;
use App\Idea;
use App\ShortListedIdea;
use Illuminate\Http\Request;

class ShortListedIdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shortListedIdeas = ShortListedIdea::with('ideas','ideas.user')->get();

        return view('admin-dashboard.short_listed_idea');
    }

    public function getShortlListedIdeas(Request $request)
    {

        // $request->year = 2019;$request->month = 06;

        $ideasOfSelectedMonth = [];
        $sendCheck = 0;

        $shortListedIdeas = ShortListedIdea::whereYear('idea_published_date', '=', $request->year)
                            ->whereMonth('idea_published_date', '=', $request->month)
                            ->with('ideas','ideas.user')
                            ->with('send_ideas')
                            ->get();
        // return $shortListedIdeas[0]->ideas->uuid;
        $i=0;                    
        foreach ($shortListedIdeas as $idea) {
            if(count($idea->send_ideas) > 0 && $sendCheck == 0){
                $sendCheck = 1;
            }
            // return $idea;
            $ideasOfSelectedMonth [$i] = [
                'shortListedIdeaId'=> $idea->id,
                'ideaId'=> $idea->ideas->id,
                'ideaUUID'=> $idea->ideas->uuid,
                'ideaTitle'=> $idea->ideas->title,
                'ideaAuthor'=> $idea->ideas->user->first_name ." ". $idea->ideas->user->last_name,
                'ideaAuthorDesignation'=> $idea->ideas->user->designation,
                'idea_published_date' =>  $idea->ideas->submitted_at,
            ];

            $i++;
        }

        $totalIdeasOfSelectedMonth = [
            'ideasOfSelectedMonth' => $ideasOfSelectedMonth,
            'sendCheck' => $sendCheck,
        ];

        return $totalIdeasOfSelectedMonth;
    }

    public function deleteFromShortListedIdea(Request $request)
    {

        // return $request->ideaId;

        $shortListedIdeas = ShortListedIdea::where('idea_id',$request->ideaId)->first();
        $shortListedIdeas->delete();
                            
        return $shortListedIdeas;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortListedIdea  $shortListedIdea
     * @return \Illuminate\Http\Response
     */
    public function show(ShortListedIdea $shortListedIdea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShortListedIdea  $shortListedIdea
     * @return \Illuminate\Http\Response
     */
    public function edit(ShortListedIdea $shortListedIdea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShortListedIdea  $shortListedIdea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShortListedIdea $shortListedIdea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShortListedIdea  $shortListedIdea
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShortListedIdea $shortListedIdea)
    {
        //
    }

    // Shortlist ideas
    public function makeShortlist(Request $request)
    {
        $ideaId =  $request->idea_id;
        $idea = Idea::find($ideaId);
        $shortlist = new ShortListedIdea();
        $shortlist->idea_id = $idea->id;
        $shortlist->idea_published_date = $idea->submitted_at;
        $shortlist->save();
        // $roles = Role::with('users')->where('id', 3)->get();
        // foreach ($roles->users as $user) {
        //     $shortlist->idea_id = $idea->id;
        //     $shortlist->user_id = $user->id;
        //     $shortlist->given_feedback = $user->id;
        // }
        return response(['success' => 'Idea shortlisted'], 201);
    }
    public function makeNonShortlist(Request $request)
    {
        $shortlist =  ShortListedIdea::where('idea_id', $request->idea_id);
        $shortlist->delete();
        return response(['success' => 'Remove from shortlist'], 201);
    }
}
