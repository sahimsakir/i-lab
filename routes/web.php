<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/php-artisan-storage-link', function () {
//     Artisan::call('storage:link');
// });

use App\Idea;
use App\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;

Route::get('/', function () {
	return Redirect::route('account.login');
	// return view('welcome');
});
Route::prefix('secure/auth')->name('account.')->group(static function () {
	Auth::routes(['register' => false]);
});

Route::prefix('2fa')->name('two_factor_authentication.')->middleware(['web', 'auth', 'isActive'])->group(static function () {
	Route::get('/', 'TwoFactorAuthenticationController@index')->name('index');
	Route::post('/', 'TwoFactorAuthenticationController@store')->name('store');
});

Route::prefix('secure/dashboard')->name('dashboard.')->middleware([
	'web',
	'auth',
	'isActive',
	'acceptTNC',
])->group(static function () {

	Route::middleware('two_factor_authentication')->group(static function () {
		Route::get('/', 'AccountDashboardController@index')->name('index');
		Route::get('/how-it-works', 'AccountDashboardController@howItWorks')->name('how-it-works');
		Route::get('/all-idea', 'AccountDashboardController@allIdeas')->name('all-idea');
		Route::get('/featured-ideas', 'AccountDashboardController@featuredIdeas')->name('featured-ideas');
		Route::get('/piloted-ideas', 'AccountDashboardController@pilotedIdeas')->name('piloted-ideas');

		Route::resource('role', 'RoleController');
		Route::resource('permission', 'PermissionController');

		Route::get('user/email-password/{user}', 'UserController@emailPassword')->name('user.email-password');
		Route::post('user/send-email-password/{user}', 'UserController@sendEmailPassword')->name('user.send-email-password');
		Route::resource('user', 'UserController');

		Route::get('users-import', 'UserController@importUsers')->name('users-import');
		Route::resource('idea', 'IdeaController');
	});

	/**FILE UPLOAD */
	Route::post('/file-upload', 'UploadController@storeUpload')->name("file-upload");

	Route::post('upload-file-delete', 'UploadController@delete_uploads_files')->name('upload-file-delete');

	Route::post('broadcast-new-idea', 'IdeaController@broadcastChannel');

	Route::get('/individual-idea-published-comments', static function () {
		return Idea::with('comments', 'comments.user', 'likes', 'ratings', 'avgRating')->whereUuid(request()->get('ideaUuid'))->first();
	});

	Route::get('/recent-idea-published', static function () {
		$recentIdeas = Idea::with('user', 'comments', 'likes', 'short_listed_idea')->whereIsActive(1)->whereIsSubmitted(1)->orderByDesc('submitted_at')
// 			->whereDate('submitted_at', '>', Carbon::now()->subDays(30))
			->get();

		return response()->json(['ideas' => $recentIdeas]);
	});



	Route::get('/all-likes-by-users/{ideaId}', static function ($ideaId) {

		$Idea = Idea::with('user', 'comments', 'likes', 'likes.user')->where('id',$ideaId)->first();
		// return $Idea;
		$user_likes = [];
		foreach ($Idea->likes as $index => $like) {
			$user_likes [$index] = [
				"name" => $like->user->first_name. " " .  $like->user->last_name,
				"photo" => $like->user->profile_picture,
				"submitted_at" => $like->updated_at,
			];
		}

		return response()->json(['user_likes' => $user_likes,'total_likes' => $index+1]);
	});

	Route::get('/all-ideas-published', static function () {
		$publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->get();

		return response()->json(['ideas' => $publishedIdeas]);
	});


	Route::get('/all-ideas', static function () {
		$publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->get();

		return response()->json(['ideas' => $publishedIdeas]);
	});

	Route::get('/recent-ideas-published', static function () {
		$previous_month = date('m') == 0 ? 12 : date('m');
		$publishedIdeas = Idea::with(
			'user',
			'comments',
			'likes',
			'short_listed_idea'
		)->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $previous_month)->get();

		return response()->json(['ideas' => $publishedIdeas]);
	});

	Route::get('/previous-ideas-published', static function () {
		$previous_month = date('m') - 1 == 0 ? 12 : date('m') - 1;
		$publishedIdeas = Idea::with(
			'user',
			'comments',
			'likes'
		)->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereMonth('submitted_at', $previous_month)->get();

		return response()->json(['ideas' => $publishedIdeas]);
	});

	Route::get('/all-featured-ideas-published', static function () {
		$featuredIdeas = Idea::with(
			'user',
			'comments',
			'likes'
		)->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereIsFeatured(1)->get();

		return response()->json(['ideas' => $featuredIdeas]);
	});

	Route::get('/all-piloted-ideas-published', static function () {
		$featuredIdeas = Idea::with(
			'user',
			'comments',
			'likes'
		)->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->whereIsPiloted(1)->get();

		return response()->json(['ideas' => $featuredIdeas]);
	});

	Route::get('my-drafted-ideas', 'IdeaController@draftedIdeas')->name('my-drafted-ideas');
	Route::get('my-featured-ideas', 'IdeaController@featuredIdeas')->name('my-featured-ideas');

	Route::get('/mySubmitted-idea-published', static function () {
		$submittedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->with('likes')->get();

		return response()->json(['ideas' => $submittedIdeas]);
	});


	Route::get('/mySubmitted-idea-published', static function () {
		$submittedIdeas = Idea::orderByDesc('updated_at')->whereUserId(auth()->id())->whereIsActive(1)->whereIsSubmitted(1)->with('likes')->get();

		return response()->json(['ideas' => $submittedIdeas]);
	});

	//Route::resource('upload', 'UploadController');
	Route::delete('upload/{upload}', 'UploadController@destroy')->name('upload.destroy');

	Route::post('new-comment', 'CommentController@store')->name('submit-new-comment');
	Route::post('delete-comment', 'CommentController@delete')->name('delete-comment');
	Route::post('edit-comment', 'CommentController@edit')->name('edit-comment');
	Route::post('update-comment', 'CommentController@update')->name('update-comment');

	Route::post('submit-like', 'LikeController@store');

	Route::post('idea-feedback', 'IdeaFeedbackController@store');

	/**
	 * Idea Rating
	 */
	Route::post('idea-rating', static function (Request $request) {
		$idea = Idea::whereUuid($request->get('idea_id'))->firstOrFail();

		$rating = \App\Rating::whereRateableId($idea->id)->whereUserId(auth()->id())->first();

		if (!$rating) {
			$rating = new \App\Rating();
			$rating->rating = $request->get('rating') ?: 0;
			$rating->user_id = auth()->id();

			$idea->ratings()->save($rating);

			return $rating;
		}

		$rating->update([
			$rating->rating = $request->get('rating') ?: 0,
		]);

		return $rating;
	});

	Route::get('my-profile', 'AccountDashboardController@myProfile')->name('my-profile');
	Route::get('my-profile/update', 'AccountDashboardController@updateMyProfile')->name('update-my-profile');
	Route::post('my-profile/update/submit', 'AccountDashboardController@updateMyProfileForm')->name('update-my-profile-form');


	/**Filtering Data */
	Route::get('/allusername', 'FilterController@getAllUserName');
	Route::post('/filter-all-ideas-published', 'FilterController@filterAllIdea');
	Route::post('/filter-all-featured-ideas-published', 'FilterController@filterAllFeaturedIdea');
	// feedback
	Route::resource('idea-feedback', 'IdeaFeedbackController');
});

Route::prefix('secure/admin')->name('admin.')->middleware([
	'web',
	'auth',
	'isActive',
	'acceptTNC',
	'two_factor_authentication',
	'role:super_administrator|administrator|moderator|maintainer',
])->group(static function () {

	Route::get('/', 'AdminDashboard\AdminDashboardController@adminDashboard')->name('admin-dashboard');
	Route::get('/recentMontIdeas', 'AdminDashboard\AdminDashboardController@recentMontIdeas')->name('admin-recentMontIdeas');
	Route::get('/previousMontIdeas', 'AdminDashboard\AdminDashboardController@previousMontIdeas')->name('admin-previousMontIdeas');
	
	Route::get('/printAllIdeas', 'AdminDashboard\AdminDashboardController@printAllIdeas')->name('admin-printAllIdeas');
	
	Route::get('/featuredIdeas', 'AdminDashboard\AdminDashboardController@featuredIdeas')->name('admin-featuredIdeas');
	Route::get('/pilotedIdeas', 'AdminDashboard\AdminDashboardController@pilotedIdeas')->name('admin-pilotedIdeas');
	Route::get('/allIdeas', 'AdminDashboard\AdminDashboardController@allIdeas')->name('admin-allIdeas');
	Route::post('/make_featured', 'AdminDashboard\AdminDashboardController@makeFeatured')->name('admin-makeFeatured');
	Route::post('/make_non_featured', 'AdminDashboard\AdminDashboardController@makeNonFeatured')->name('admin-makeNonFeatured');

	Route::post('/make_piloted', 'AdminDashboard\AdminDashboardController@makePiloted')->name('admin-makePiloted');
	Route::post('/make_non_piloted', 'AdminDashboard\AdminDashboardController@makeNonPiloted')->name('admin-makeNonPiloted');

	// Shortlist ideas
	Route::post('/make_shortlist', 'ShortListedIdeaController@makeShortlist')->name('admin-makeShortlist');
	Route::post('/make_non_shortlist', 'ShortListedIdeaController@makeNonShortlist')->name('admin-makeNonShortlist');


	//  API for Vue 
	Route::get('/all-ideas-published', static function () {
		$publishedIdeas = Idea::with('user', 'comments', 'likes')->orderByDesc('submitted_at')->whereIsActive(1)->whereIsSubmitted(1)->get();
		return response()->json(['ideas' => $publishedIdeas]);
	});

	// feedback
	Route::resource('short-listed-idea', 'ShortListedIdeaController');
	Route::post('get-short-listed-idea-by-month', 'ShortListedIdeaController@getShortlListedIdeas');
	// Route::get('get-short-listed-idea-by-month', 'ShortListedIdeaController@getShortlListedIdeas');
	Route::post('delete-from-short-listed-idea', 'ShortListedIdeaController@deleteFromShortListedIdea');

	// Send EMAIL
	Route::resource('send-idea', 'SendIdeaController');
	Route::post('resend-idea', 'SendIdeaController@resendIdeasByEmail');
	// Route::get('resend-idea', 'SendIdeaController@resendIdeasByEmail');


	//featured by likes
	Route::get('/settings', 'OperationController@index')->name("settings");
	Route::post('/amount_of_likes', 'OperationController@amounOfLike')->name("amounOfLike");
	Route::post('/make-featured-by-likes', 'OperationController@makeFeaturedByLikes')->name("makeFeaturedByLikes");

});

Route::prefix('terms')->name('terms.')->group(static function () {
	Route::get('/', 'AccountDashboardController@acceptTermsAndConditions')->name('show');
	Route::post('/', 'AccountDashboardController@confirmTermsAndConditions')->name('update');
});

Route::group([
	'prefix' => 'file-manager',
	'middleware' => ['web', 'auth', 'isActive', 'acceptTNC', 'two_factor_authentication'],
], static function () {
	UniSharp\LaravelFilemanager\Lfm::routes();
});