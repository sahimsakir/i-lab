<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Notifications\SendIdeaNotification;
use App\Role;
use App\SendIdea;
use Illuminate\Http\Request;

class SendIdeaController extends Controller
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
        $ideas = $request->ideas;
        // dd($ideas);
        $moderators = Role::with('users')->where('name', 'moderator')->first();
        if (count($moderators->users)) {
            foreach ($ideas as $tmpIdea) {
                $idea = (object) $tmpIdea;
                // return var_dump($idea->idea_id);
                foreach ($moderators->users as $user) {
                    $sendIdea = SendIdea::where([
                        ['idea_id', '=', $idea->idea_id],
                        ['user_id', '=', $user->id],
                    ])->first();

                    if (!$sendIdea) {
                        $tmp = new SendIdea();
                        $tmp->idea_id = $idea->idea_id;
                        $tmp->user_id = $user->id;
                        $tmp->shortlist_id = $idea->shortlist_id;
                        $tmp->given_feedback = false;
                        $tmp->idea_published_date = $idea->idea_published_date;
                        $tmp->save();
                    }
                }
            }

            $admin_notify_msg = 'An email is sent to all moderators';
            return $this->sendMailToModerator($ideas, $moderators->users, $admin_notify_msg);
        } else {
            return response()->json(['err' => "No Moderator found"]);
        }
    }

    /**
     * Check Sendmail table and resend ideas to them who don't feedback yet..
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendIdeasByEmail(Request $request)
    {
        $ideas = $request->ideas;
        // return ($ideas[4]);
        $moderators = Role::with('users')->where('name', 'moderator')->first();
        // return $moderators;
        if (count($moderators->users)) {
            foreach ($ideas as $index => $tmpIdea) {
                // echo $index;
                $idea = (object) $tmpIdea;
                // return var_dump($idea->idea_id);
                foreach ($moderators->users as $user) {
                    $sendIdea = SendIdea::where([
                        ['idea_id', '=', $idea->idea_id],
                        ['user_id', '=', $user->id],
                    ])->first();

                   

                    if (!$sendIdea) {
                        $tmp = new SendIdea();
                        $tmp->idea_id = $idea->idea_id;
                        $tmp->user_id = $user->id;
                        $tmp->shortlist_id = $idea->shortlist_id;
                        $tmp->given_feedback = false;
                        $tmp->idea_published_date = $idea->idea_published_date;
                        $tmp->save();
                    }else{
                        if($sendIdea->given_feedback){
                            //remove the idea from ideas where the moderator already gave feedback 
                            unset($ideas[$index]);
                        }
                    }
                }
            }
            // return count($ideas);
            $admin_notify_msg = "A remember email is sent to all moderators who don't give feedback yet";
            return $this->sendMailToModerator($ideas, $moderators->users, $admin_notify_msg);
        } else {
            return response()->json(['err' => "No Moderator found"]);
        }
    }


    /**
     * send mail to all moderators
     *
     * @param [type] $ideas
     * @param [type] $moderators
     * @return void
     */
    public function sendMailToModerator($ideas, $moderators, $admin_notify_msg)
    {
        $allIdeaDetail = [];
        $whichDate = null;
        foreach ($ideas as $tmpIdea) {
            // return $tmpIdea;
            $idea = (object) $tmpIdea;
            $tmp = Idea::find($idea->idea_id);
            array_push($allIdeaDetail, $tmp);
            $whichDate = $idea->idea_published_date;
        }
        foreach ($moderators as $user) {
            $user->notify(new SendIdeaNotification($user, $allIdeaDetail, $whichDate));
        }
        return response()->json(['success' => $admin_notify_msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SendIdea  $sendIdea
     * @return \Illuminate\Http\Response
     */
    public function show(SendIdea $sendIdea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SendIdea  $sendIdea
     * @return \Illuminate\Http\Response
     */
    public function edit(SendIdea $sendIdea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SendIdea  $sendIdea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SendIdea $sendIdea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SendIdea  $sendIdea
     * @return \Illuminate\Http\Response
     */
    public function destroy(SendIdea $sendIdea)
    {
        //
    }
}