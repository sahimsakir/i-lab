<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Comment
 *
 * @property int $id
 * @property int $idea_id
 * @property int $user_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Idea $idea
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Idea
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $is_active
 * @property int $is_submitted
 * @property string|null $submitted_at
 * @property int $is_approved
 * @property string|null $approved_at
 * @property int $is_featured
 * @property string|null $featured_at
 * @property int $is_read
 * @property string $topic
 * @property string $title
 * @property string $elevator_pitch
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $average_rating
 * @property-read mixed $sum_rating
 * @property-read mixed $user_average_rating
 * @property-read mixed $user_sum_rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IdeaFeedback[] $idea_feedback
 * @property-read int|null $idea_feedback_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\willvincent\Rateable\Rating[] $ratings
 * @property-read int|null $ratings_count
 * @property-read \App\ShortListedIdea $short_listed_idea
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Upload[] $uploads
 * @property-read int|null $uploads_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereElevatorPitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereFeaturedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereIsSubmitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Idea whereUuid($value)
 */
	class Idea extends \Eloquent {}
}

namespace App{
/**
 * App\IdeaFeedback
 *
 * @property-read \App\Idea $ideas
 * @property-read \App\ShortListedIdea $short_listed_idea
 * @property-read \App\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdeaFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdeaFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IdeaFeedback query()
 */
	class IdeaFeedback extends \Eloquent {}
}

namespace App{
/**
 * App\Like
 *
 * @property int $id
 * @property int $idea_id
 * @property int $user_id
 * @property int $is_liked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Idea $idea
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereIsLiked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Like whereUserId($value)
 */
	class Like extends \Eloquent {}
}

namespace App{
/**
 * App\Operation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operation query()
 */
	class Operation extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUuid($value)
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\Rating
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $rating
 * @property string $rateable_type
 * @property int $rateable_id
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $rateable
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereRateableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereRateableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Rating whereUserId($value)
 */
	class Rating extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUuid($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\SendIdea
 *
 * @property-read \App\Idea $ideas
 * @property-read \App\ShortListedIdea $short_listed_idea
 * @property-read \App\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SendIdea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SendIdea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SendIdea query()
 */
	class SendIdea extends \Eloquent {}
}

namespace App{
/**
 * App\ShortListedIdea
 *
 * @property-read \App\Idea $ideas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SendIdea[] $send_ideas
 * @property-read int|null $send_ideas_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShortListedIdea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShortListedIdea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShortListedIdea query()
 */
	class ShortListedIdea extends \Eloquent {}
}

namespace App{
/**
 * App\Upload
 *
 * @property int $id
 * @property string $uuid
 * @property int $idea_id
 * @property string|null $title
 * @property string $file
 * @property float $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Idea $idea
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Upload whereUuid($value)
 */
	class Upload extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $uuid
 * @property int $is_active
 * @property string $staff_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $cell_number
 * @property string|null $designation
 * @property string|null $team
 * @property string|null $profile_picture
 * @property int $tnc_accepted
 * @property string|null $tnc_accepted_at
 * @property string $password
 * @property string|null $two_factor_auth_token
 * @property string|null $two_factor_auth_expiry
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Idea[] $ideas
 * @property-read int|null $ideas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCellNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTncAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTncAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTwoFactorAuthExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTwoFactorAuthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid($value)
 */
	class User extends \Eloquent {}
}

