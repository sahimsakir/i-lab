<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Upload;
use Carbon\Carbon;
use App\Authorizable;
use Illuminate\Http\Request;
use App\Events\NewIdeaChannel;
use App\IdeaFeedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
// use File;

class IdeaController extends Controller
{
    use Authorizable;

    /**
     * IdeaController constructor.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {


        $draftedIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(0)->whereIsSubmitted(0)->count();

        $featuredIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->whereIsApproved(1)->whereIsFeatured(1)->count();

        $submittedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->with('likes')->get();

        $activeIdeaCard = "submitted";

        return view('idea.index', compact('submittedIdeas', 'draftedIdeasCount', 'featuredIdeasCount', 'activeIdeaCard'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function draftedIdeas()
    {
        $draftedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(0)->whereIsSubmitted(0)->get();

        $submittedIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->count();

        $featuredIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->whereIsApproved(1)->whereIsFeatured(1)->count();

        $activeIdeaCard = "drafted";

        return view('idea.drafted-ideas', compact('draftedIdeas', 'submittedIdeasCount', 'featuredIdeasCount', 'activeIdeaCard'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function featuredIdeas()
    {
        $featuredIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->whereIsApproved(1)->whereIsFeatured(1)->get();

        $draftedIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(0)->whereIsSubmitted(0)->count();

        $submittedIdeasCount = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->count();

        $activeIdeaCard = "featured";

        return view('idea.featured-ideas', compact('featuredIdeas', 'draftedIdeasCount', 'submittedIdeasCount', 'activeIdeaCard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('idea.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */


    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // return $request;

        $validator = Validator::make($request->all(), [
            'topic' => 'required|max:60',
            'title' => 'required|max:100',
            'elevator_pitch' => 'required|max:1536',
            'description' => 'present|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        switch ($request->get('submit_button')) {

            case 'Publish':
                if ($request->idea_id == '') {
                    $idea = new Idea();
                } else {
                    $idea = Idea::where('id', $request->idea_id)->first();
                }
                $idea->user_id = auth()->id();
                $idea->is_active = true;
                $idea->is_submitted = true;
                $idea->submitted_at = Carbon::now();
                $idea->topic = $request->get('topic');
                $idea->title = $request->get('title');
                $idea->elevator_pitch = $request->get('elevator_pitch');
                $idea->description = $request->get('description');
                $idea->save();

                break;
            case 'Draft':

                if ($request->idea_id == '') {
                    $idea = new Idea();
                } else {
                    $idea = Idea::where('id', $request->idea_id)->first();
                }

                $idea->user_id = auth()->id();
                $idea->is_active = false;
                $idea->is_submitted = false;
                $idea->topic = $request->get('topic');
                $idea->title = $request->get('title');
                $idea->elevator_pitch = $request->get('elevator_pitch');
                $idea->description = $request->get('description');
                $idea->save();

                break;
        }

        if ($idea->is_active) {
            laraflash()->message($idea->title . ' was updated with Submitted Status on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

            //return redirect()->route('dashboard.idea.edit', $idea->uuid);

            return redirect()->route('dashboard.idea.index');
        }

        laraflash()->message($idea->title . ' was updated with Draft Status on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.idea.edit', $idea->uuid);
    }


    public function broadcastChannel(Request $request)
    {
        $idea = Idea::with('user')->whereUuid($request->get('idea_id'))->firstOrFail();

        // Broadcast to channel
        broadcast(new NewIdeaChannel($idea))->toOthers();

        return $idea;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Idea  $idea
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function show(Idea $idea)
    {
        if ($idea->user_id == auth()->id()) {
            $idea->is_read = true;
            $idea->update();
        }
        $idea = Idea::whereId($idea->id)->with('short_listed_idea', 'idea_feedback')->first();
        $idea_feedback = IdeaFeedback::where([
            ['idea_id', '=', $idea->id],
            ['user_id', '=', auth()->user()->id],
        ])->first();
        $idea->idea_feedback = $idea_feedback;
        // return $idea;
        return view('idea.show', compact('idea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $idea
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($idea)
    {
        $idea = Idea::whereUserId(auth()->id())->whereUuid($idea)->firstOrFail();
        $fileSizeCount = Upload::whereIdeaId($idea->id)->sum('size');

        if ($idea->user_id != Idea::whereUuid(request()->segment(4))->first()->user_id) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }

        if ($idea->user_id == auth()->id()) {
            return view('idea.edit', compact('idea', 'fileSizeCount'));
        }

        laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param $idea
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $idea)
    {
        $idea = Idea::with(['uploads', 'comments', 'short_listed_idea'])->whereUuid($idea)->whereUserId(auth()->id())->firstOrFail();

        if ($idea->user_id != Idea::whereUuid(request()->segment(4))->first()->user_id) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }

        if ($idea->user_id != auth()->id()) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'topic' => 'required|max:60',
            'title' => 'required|max:100',
            'elevator_pitch' => 'required|max:1536',
            'description' => 'present|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        switch ($request->get('submit_button')) {

            case 'Publish':

                $idea->user_id = auth()->id();
                $idea->is_active = true;
                $idea->is_submitted = true;
                $idea->submitted_at = Carbon::now();
                $idea->topic = $request->get('topic');
                $idea->title = $request->get('title');
                $idea->elevator_pitch = $request->get('elevator_pitch');
                $idea->description = $request->get('description');
                $idea->update();

                // if ($request->hasFile('file')) {
                //     $fileName = $request->file('file')->getClientOriginalName();

                //     $upload = new Upload(['file' => $request->file('file'), 'title' => sr(pathinfo($fileName, PATHINFO_FILENAME)) ?: 'Untitled']);
                //     $idea->uploads()->save($upload);
                // }

                break;
            case 'Draft':
                $idea->user_id = auth()->id();
                $idea->is_active = false;
                $idea->is_submitted = false;
                $idea->topic = $request->get('topic');
                $idea->title = $request->get('title');
                $idea->elevator_pitch = $request->get('elevator_pitch');
                $idea->description = $request->get('description');
                $idea->update();

                // if ($request->hasFile('file')) {
                //     $fileName = $request->file('file')->getClientOriginalName();

                //     $upload = new Upload(['file' => $request->file('file'), 'title' => sr(pathinfo($fileName, PATHINFO_FILENAME)) ?: 'Untitled']);
                //     $idea->uploads()->save($upload);
                // }

                break;
        }

        if ($idea->is_active) {
            laraflash()->message($idea->title . ' was updated with Submitted Status on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

            //return redirect()->route('dashboard.idea.edit', $idea->uuid);

            return redirect()->route('dashboard.idea.index');
        }

        laraflash()->message($idea->title . ' was updated with Draft Status on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.idea.edit', $idea->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Idea  $idea
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Idea $idea)
    {
        if ($idea->user_id != Idea::whereUuid(request()->segment(4))->first()->user_id) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }

        if ($idea->user_id != auth()->id()) {
            laraflash()->message('Whoops! Sorry, but you are not allowed to perform the action requested.')->danger();

            return redirect()->back();
        }

        $uploads = $idea->uploads;
        $filePath = public_path() . '/idea/files/';
        $flag = true;
        $isSubmitted = $idea->is_submitted;

        if (!empty($uploads)) {
            foreach ($uploads as $upload) {
                if (File::exists($filePath . $upload->file)) {
                    $flag = File::delete($filePath . $upload->file);
                } else {
                    laraflash()->message('Whoops! Sorry, Idea not deleted.')->danger();
                    switch ($isSubmitted) {
                        case 0:
                            return redirect()->route('dashboard.my-drafted-ideas');
                            break;

                        case 1:
                            return redirect()->route('dashboard.idea.index');
                            break;
                    }
                }
            }
        }

        if ($flag) {
            $idea->delete();
            laraflash()->message('Idea: ' . $idea->title . ' was deleted on ' . Carbon::now()->format('F j, Y, g:i A'))->success();
        } else {
            laraflash()->message('Whoops! Sorry, Idea not deleted.')->danger();
        }

        // laraflash()->message('Idea: ' . $idea->title . ' was deleted on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        // return redirect()->route('dashboard.my-drafted-ideas');

        switch ($isSubmitted) {
            case 0:
                return redirect()->route('dashboard.my-drafted-ideas');
                break;

            case 1:
                return redirect()->route('dashboard.idea.index');
                break;
        }
    }
}