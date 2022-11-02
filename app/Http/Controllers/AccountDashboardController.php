<?php

namespace App\Http\Controllers;

use App\Idea;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class AccountDashboardController extends Controller
{
    /**
     * AccountDashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware(['web', 'auth', 'isActive',]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $month = date('m');

        /*$data = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $month)->get();
        return $data;*/

        // return Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereDate('submitted_at', '>', Carbon::now()->subDays(30))->get();

        $totalIdeasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->count();
        $recentIdeasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereDate('submitted_at', '>', Carbon::now()->subDays(30))->count();
        // $recentIdeasCount = Idea::orderByDesc('created_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $month)->count();

        $featuredIdeas = Idea::orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereIsFeatured(1)->whereIsApproved(1)->take(3)->get();

        $myIdeaDrafted = Idea::whereUserId(auth()->id())->whereIsSubmitted(0)->whereIsActive(0)->orderByDesc('id')->first();
        $myIdeaSubmitted = Idea::whereUserId(auth()->id())->whereIsSubmitted(1)->whereIsActive(1)->orderByDesc('id')->first();

        return view('dashboard', compact('recentIdeasCount', 'featuredIdeas', 'myIdeaDrafted', 'myIdeaSubmitted', 'totalIdeasCount'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function acceptTermsAndConditions()
    {
        if (auth()->check() && auth()->user()->tnc_accepted == true) {
            return redirect()->route('dashboard.index');
        }

        return view('partials.terms-and-conditions');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmTermsAndConditions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accept_the_terms_of_service' => ['required', 'accepted'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('accept_the_terms_of_service')) {
            $user = User::find(auth()->id());
            $user->tnc_accepted = true;
            $user->tnc_accepted_at = Carbon::now();
            $user->update();
        }

        laraflash()->message('You have agreed to the Terms of Service Agreement on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function howItWorks()
    {
        return view('how-it-works');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allIdeas()
    {
        $users = User::orderBy('first_name')->get();
        $name = [];

        foreach ($users as $user) {
            $obj['uuid'] = $user->id;
            $obj['name'] = $user->full_name;

            array_push($name, $obj);
        }
        return view('all-ideas')->withUsers($name);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function featuredIdeas()
    {
        $users = User::orderBy('first_name')->get();
        $name = [];

        foreach ($users as $user) {
            $obj['uuid'] = $user->id;
            $obj['name'] = $user->full_name;

            array_push($name, $obj);
        }
        return view('featured-ideas')->withUsers($name);
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pilotedIdeas()
    {
        $users = User::orderBy('first_name')->get();
        $name = [];

        foreach ($users as $user) {
            $obj['uuid'] = $user->id;
            $obj['name'] = $user->full_name;

            array_push($name, $obj);
        }
        return view('piloted-ideas')->withUsers($name);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myProfile()
    {
        return view('my-profile');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateMyProfile()
    {
        $image = DB::table("users")->where(['id' => auth()->id()])->get();

        return view('update-my-profile', compact('image'));
    }

    /**
     * Update My Profile Form (Post Request)
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMyProfileForm(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Fetch the authenticated user information
        $user = User::find(auth()->id());

        if ($request->filled('password')) {
            $validator = Validator::make($request->all(), [
                'cell_number' => 'present|nullable|max:20',
                'designation' => 'present|nullable|max:120',
                'team' => 'present|nullable|max:60',
                'password' => 'required|confirmed|min:8|max:255',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'cell_number' => 'present|nullable|max:20',
                'designation' => 'present|nullable|max:120',
                'team' => 'present|nullable|max:60',
            ]);
        }

        $filters = [
            'designation' => 'trim|escape|capitalize',
            'team' => 'trim|escape|capitalize',
        ];

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Query form file input
        $profile_picture = $request->profile_picture;

        if ($profile_picture != null) {
            // Generate new image name with proper destination location
            $imageName = 'storage/uploads/profile-picture/' . Str::random(60) . '.jpg';

            // Convert the Base64 Encoded Image Data With a Cropped Version
            $resized_image = \Image::make($profile_picture)->resize(300, 300)->stream('jpg', 100);
            // dd($resized_image);

            // Store the newly converted image to file storage
            Storage::disk('public')->put($imageName, $resized_image);

            // Unlink/ Delete Old File Before Storing New One to the Database
            File::delete($user->profile_picture);
            
            // Store New File Location Information to Database and include to storage directory as prefix

            $user->profile_picture =  $imageName;
        }

        $user->cell_number = $request->cell_number;
        $user->designation = $request->designation;
        $user->team = $request->team;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        laraflash()->message('Your profile was updated on ' . Carbon::now()->format('F j, Y, g:i A'))->success();

        return redirect()->route('dashboard.update-my-profile');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string
     */
    public function changeProfileImage(Request $request)
    {
        return 'success';
    }
}