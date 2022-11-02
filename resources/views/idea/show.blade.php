@extends('layouts.app')

@section('site_title', $idea->title)

@section('bg_image', 'show-idea-page full-height')

@section('header_tag')
    <style>
        /* body {
            font-family: sans-serif;
            font-weight: 800;
        } */
        .switch {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150px;
            height: 40px;
            text-align: center;
            margin: -20px 0 0 -50px;
            background: #4cd964;
            -webkit-transition: all 0.2s ease;
            -moz-transition: all 0.2s ease;
            -o-transition: all 0.2s ease;
            -ms-transition: all 0.2s ease;
            transition: all 0.2s ease;
            border-radius: 25px;
        }
        .switch span {
            position: absolute;
            width: 20px;
            height: 4px;
            top: 50%;
            left: 50%;
            margin: -2px 0px 0px -4px;
            background: #fff;
            display: block;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transition: all 0.2s ease;
            -moz-transition: all 0.2s ease;
            -o-transition: all 0.2s ease;
            -ms-transition: all 0.2s ease;
            transition: all 0.2s ease;
            border-radius: 2px;
        }
        .switch span:after {
            content: "";
            display: block;
            position: absolute;
            width: 4px;
            height: 12px;
            margin-top: -8px;
            background: #fff;
            -webkit-transition: all 0.2s ease;
            -moz-transition: all 0.2s ease;
            -o-transition: all 0.2s ease;
            -ms-transition: all 0.2s ease;
            transition: all 0.2s ease;
            border-radius: 2px;
        }
        input[type=radio] {
            display: none;
        }
        .switch label {
            cursor: pointer;
            color: rgba(0,0,0,0.2);
            width: 60px;
            line-height: 50px;
            -webkit-transition: all 0.2s ease;
            -moz-transition: all 0.2s ease;
            -o-transition: all 0.2s ease;
            -ms-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }


        label[for=yes] {
            position: absolute;
            left: 0px;
            height: 20px;
            top: -10%;
        }
        label[for=no] {
            position: absolute;
            right: 0px;
            top: -10%;
        }
        #no:checked ~ .switch {
            background: #ff3b30;
        }
        #no:checked ~ .switch span {
            background: #fff;
            margin-left: -8px;
        }
        #no:checked ~ .switch span:after {
            background: #fff;
            height: 20px;
            margin-top: -8px;
            margin-left: 8px;
        }
        #yes:checked ~ .switch label[for=yes] {
            color: #fff;
        }
        #no:checked ~ .switch label[for=no] {
            color: #fff;
        }


        /* Style for yes-no-2 */
        label[for=yes_2] {
            position: absolute;
            left: 0px;
            height: 20px;
            top: -10%;
        }
        label[for=no_2] {
            position: absolute;
            right: 0px;
            top: -10%;
        }
        #no_2:checked ~ .switch {
            background: #ff3b30;
        }
        #no_2:checked ~ .switch span {
            background: #fff;
            margin-left: -8px;
        }
        #no_2:checked ~ .switch span:after {
            background: #fff;
            height: 20px;
            margin-top: -8px;
            margin-left: 8px;
        }
        #yes_2:checked ~ .switch label[for=yes_2] {
            color: #fff;
        }
        #no_2:checked ~ .switch label[for=no_2] {
            color: #fff;
        }

        .btn_submit{
            margin-top: 25px;
        }

    </style>
@endsection

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            {!! laraflash()->render() !!}

            @unless (empty($idea))
                <div class="individual-idea-page mb-3">
                    <h5 class="individual-idea-page-idea-title mb-3">Idea Title: {{ $idea->title }}</h5>
                    <!-- /.individual-idea-page-idea-title -->

                    <div class="mb-4">
                        <strong class="individual-idea-page-idea-topic">Topic: {{ $idea->topic }}</strong>
                        <!-- /.individual-idea-page-idea-topic -->
                    </div>
                    <!-- /.mb-4 -->

                    <div class="mb-4">
                        <h5 class="text-deep-purple">Elevator Pitch</h5>
                        <!-- /.text-deep-purple mb-0 -->
                        <p class="mb-0">{{ $idea->elevator_pitch }}</p>
                    </div>
                    <!-- /.mb-4 -->

                    <div class="mb-4">
                        <h5 class="text-deep-purple">Description</h5>
                        <!-- /.text-deep-purple mb-0 -->
                        {!! $idea->description !!}
                    </div>
                    <!-- /.mb-4 -->

                    <div class="clearfix"></div>
                    <div class="row mb-4">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            @unless (empty($idea->uploads()->exists()))
                                <div class="mb-1">
                                    <strong class="text-deep-purple border-bottom">Files Uploaded</strong>
                                    <!-- /.text-deep-purple -->
                                </div>
                                <!-- /.mb-3 -->

                                @foreach ($idea->uploads as $upload)
                                    <ul class="list-unstyled mb-1">
                                        <li>
                                            <a href="{{ asset("/idea/files/$upload->file")  }}">{{ $upload->title }} ({{ strtoupper(\File::extension($upload->file)) }})</a>
                                        </li>
                                    </ul>
                                @endforeach
                            @endunless
                        </div>
                        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
                    </div>
					<!-- /.row mb-4 -->

					@if ($idea->is_submitted)
                    <div class="idea-submitted-by mb-4">
                        <div class="mb-2">
                            <strong>Idea Submitted By:</strong>
                        </div>
                        <!-- /.mb-2 -->

                        <div class="media">
                            @if($idea->user->profile_picture != null)
                                <img src="{{ asset($idea->user->profile_picture) }}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
                            @else
                                <img src="{{asset('img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
                            @endif
                            <div class="media-body">
                                <strong class="mt-0">{{ $idea->user->first_name }} {{ $idea->user->last_name }}</strong>
                                <p class="mb-0">{{ $idea->user->designation }}</p>
                                <!-- /.mb-0 -->
                            </div>
                        </div>
					</div>

                    <!-- /.idea-submitted-by -->
                </div>
                <!-- /.individual-idea-page mb-3 -->

                <div v-if="ratingSubmitSuccess" v-show="elementVisible" class="alert alert-success alert-dismissible fade show" role="alert">
                    @{{ ratingSubmitSuccess }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row mb-4" @if (!$agent->isMobile()) style="display: flex;color: #00BAFF;" @endif>

                    <div class="col-12 col-md-4 col-lg-4 @if ($agent->isMobile()) mb-2 @endif">
                        <div>
                            <span class="mr-2" style="color: #00BAFF;">@{{ totalComments }}</span> comments
                            <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2">
                            <a href="javascript:void(0)" @click="likedBy(ideaId)" >
                                <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{totalLikes}} likes</span>
                            </a>
                            {{-- <img @click="like(ideaId)" src="{{ asset('img/like.svg') }}" height="16" alt=""> --}}
                            <span v-if="isLiked({{\Illuminate\Support\Facades\Auth::user()->id}})">
                                <img id="ideaId" class="like-btn" @click="like(ideaId)" src="{{ asset('img/like.svg') }}" class="" height="16" alt="">
                            </span>
                            <span v-else>
                                <img id="ideaId'" class="like-btn" @click="like(ideaId)" src="{{ asset('img/like_gray.svg') }}" class="" height="16" alt="">
                            </span>
                        </div>
                    </div>
                    <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                    {{-- <div class="col-12 col-sm-8 col-md-8 col-lg-8" @if ($agent->isMobile()) style="line-height: 2.15 !important;" @endif>
                        <div class="@if (!$agent->isMobile()) text-right @endif">
                            <span v-for="(rating, index) in avgRating" :key="index"><span class="view-more-button mr-1">Rating (@{{ rating.avgRating }}/5)</span></span><span class="text-muted">|</span>
                            @{{ ratings.length }} admin(s) rated <span class="text-muted mr-1">|</span>
                            <span v-for="(myRating, index) in ratings" :key="index"><span v-if="myRating.user_id == {{ auth()->id() }}">You rated: @{{ myRating.rating }}</span></span><span class="text-muted ml-1">|</span>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="0">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>0</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="1">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>1</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="2">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>2</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="3">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>3</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="4">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>4</label>
                                </div>
                            </div>

                            <div class="pretty p-icon p-round p-plain p-smooth p-svg p-tada">
                                <input type="radio" v-model="ratingValue" value="5">
                                <div class="state">
                                    <img class="svg" src="{{ asset('img/star.svg') }}" alt=""/>
                                    <label>5</label>
                                </div>
                            </div>

                            <button @click="ideaRating()" class="btn btn-success btn-sm">Rate</button>
                        </div>
                        <!-- /.text-right -->
                    </div> --}}
                    <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                    @hasanyrole('super_administrator|administrator|moderator|maintainer')

                        @if ($idea->short_listed_idea)
                            {{-- RATING VIA MODERATOR --}}
                            <div class="col-12 col-md-8 col-lg-8 mt-sm-4 mt-md-0" @if ($agent->isMobile()) style="line-height: 2.15 !important;" @endif>
                                <div class="@if (!$agent->isMobile()) text-right @endif">

                                    <form @submit.prevent="ideaRating">
                                        <div class="row ">
                                            <div class="col-sm-10">
                                                <div class="row">
                                                    <div class="col-12 col-sm-8 mr-2" @if ($agent->isMobile()) style="margin-bottom: 20px !important;" @endif>
                                                        <span>
                                                            Do you want to feature this idea?    
                                                        </span>
                                                    </div>
                                                    <div class="col-12 col-sm-2">
                                                        <input type="radio" name="is_featured" v-model="is_featured" id="yes" value="1"  />
                                                        <input type="radio" name="is_featured" v-model="is_featured" id="no" value="2" />
                                                        <div class="switch">
                                                            <label for="yes">Yes</label>
                                                            <label for="no">No</label>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (!$agent->isMobile()) <hr> @endif
                                                <div class="row">
                                                    <div class="col-sm-8 mr-2" @if ($agent->isMobile()) style="margin: 20px auto !important;" @endif>
                                                        <span>
                                                            Do you want to sponsor this idea?  
                                                        </span>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="radio" name="is_sponsored" v-model="is_sponsored" id="yes_2" value="1"/>
                                                        <input type="radio" name="is_sponsored" v-model="is_sponsored" id="no_2" value="2"/>
                                                        <div class="switch">
                                                            <label for="yes_2">Yes</label>
                                                            <label for="no_2">No</label>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 ">
                                                <button type="submit" class="btn btn-info btn_submit">submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    

                                </div>
                                <!-- /.text-right -->
                            </div>
                        @endif
                    @endhasanyrole
                    <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                </div>
                <!-- /.row -->

                <div class="card p-3" style="border-radius: 10px;">
                    <ul class="list-unstyled" v-for="(comment, index) in comments" :key="index">
                        <li class="media mb-2">
                            <span v-if="comment.user.profile_picture == undefined">
                                <img src="/img/profile-picture-placeholder.svg" class="mr-2 rounded-circle" alt="Profile Picture" height="40" style="border: 1px solid #00BAFF;">
                            </span>

                            <span v-else>
                                <img :src="'{{asset('/')}}' + comment.user.profile_picture" class="mr-2 rounded-circle" alt="Profile Picture" height="40" style="border: 1px solid #00BAFF;">
                            </span>

                            <div class="media-body">
                                <h5 class="mt-0 mb-1 text-deep-purple" style="font-weight: 600; font-size: 14px;">@{{ comment.user.first_name }} @{{ comment.user.last_name }}</h5>
                                <div style="font-size: 13px;">
                                    @{{ comment.comment }}

                                    {{-- @if(comment.user_id == Auth::user()->id) --}}
                                    <div v-if="comment.user_id == {{\Illuminate\Support\Facades\Auth::user()->id}}" class="mr-3 comment_edit_delete" style="float: right">
                                        <img @click="deleteComment(comment.id)" src="{{ asset('img/cross_10px.svg') }}" class="pr-3 comment_delete" height="16" alt="" style="float: right">
                                        <img @click="editComment(comment.id)" src="{{ asset('img/edit.svg') }}" class="pr-3 comment_edit" height="16" alt="" style="float: right">
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="input-group" style="border-bottom: none;">
                        <input type="text" v-model="newComment" @keyup.enter="commentId == '' ? submit() : updateComment()" class="form-control" @enter placeholder="Write a comment..." aria-describedby="button-addon2" required>
                        <input type="hidden" v-model="commentId" class="form-control" placeholder="Write a comment..." aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button @click="submit()" v-if="commentId===''" class="btn btn-outline-primary" id="button-addon2">Comment</button>
                            <button @click="updateComment()" v-else class="btn btn-outline-primary" id="button-addon3">Update</button>
                        </div>
                    </div>
                    <input type="hidden" v-model="uuid">

				</div>
				@endif
                <!-- /.card card-shadow -->
            @endunless
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->


        @include('modals.like_modal');

    </div>
    <!-- /.row -->
@endsection

@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

    <script>
			function deleteAlert() {
				alert('you want to delete you comment !');
			}

			Vue.config.devtools = true;

			const app = new Vue({
				el: '#app',
				data() {
					return {
						newComment: '',
						commentId: '',
						totalComments: 0,
						totalLikes: 0,
						ideaUuid: '{{ $idea->uuid }}',
						uuid: '',
						comments: [],
						ideaId: '{{ $idea->id }}',
						likes: [],
						ratingValue: '',
						ratings: [],
						ratingSubmitSuccess: '',
						avgRating: [],
						elementVisible: true,
                        is_featured: '{{ $idea->idea_feedback ? $idea->idea_feedback->is_featured : 2 }}',
                        is_sponsored: '{{ $idea->idea_feedback ? $idea->idea_feedback->is_sponsored : 2 }}',
                        shortlist_id: '{{ $idea->short_listed_idea ? $idea->short_listed_idea->id : null }}',


                        // modal of likes: 
                        user_likes: [],
                        total_likes: 0,
					};
				},
				methods: {
					created() {
						axios.get(`/secure/dashboard/individual-idea-published-comments?ideaUuid=${this.ideaUuid}`).then((response) => {
							this.comments = response.data.comments;
							this.totalComments = response.data.comments.length;
							this.totalLikes = response.data.likes.length;
							this.likes = response.data.likes;
							this.uuid = response.data.uuid;
							this.ratings = response.data.ratings;
							this.avgRating = response.data.avg_rating;
							// console.log(response.data);
						}).catch((err) => {
							console.log(err.response);
						});

						Echo.channel('idea').listen('NewComment', (e) => {
							this.comments.push({
								comment: e.comment,
							});
						});
					},
					submit() {
						axios.post('/secure/dashboard/new-comment', {
							comment: this.newComment,
							idea_id: this.uuid,
						}).then((response) => {
							this.newComment = '';
							this.comments.push(response.data);
							this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					deleteComment(commentId) {
						//alert("comment id: "+commentId);
						if (confirm('you want to delete you comment !')) {
							axios.post('/secure/dashboard/delete-comment', {
								comment_id: commentId,

							}).then((response) => {
								// console.log(response);
								//this.newComment = '';
								//this.comments.push(response.data);
								//this.totalComments = parseInt(this.totalComments) + 1;
							}).catch((err) => {
								console.log(err.response.data);
							});
						}
					},
					editComment(commentId) {
						//alert("Edit: "+commentId);
						axios.post('/secure/dashboard/edit-comment', {
							comment_id: commentId,

						}).then((response) => {
							// console.log(response);
							this.newComment = response.data.comment;
							this.commentId = response.data.id;
							//this.comments.push(response.data);
							//this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					updateComment() {
						// alert(this.newComment);
						axios.post('/secure/dashboard/update-comment', {
							comment_id: this.commentId,
							comment: this.newComment,

						}).then((response) => {
							// console.log(response);
							this.newComment = '';
							this.commentId = '';
							//this.comments.push(response.data);
							//this.totalComments = parseInt(this.totalComments) + 1;
						}).catch((err) => {
							console.log(err.response.data);
						});
					},
					like(ideaId) {
						axios.post(`/secure/dashboard/submit-like`, {idea_id: ideaId}).then((response) => {
							this.created();

							//console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
                    likedBy(ideaId){
                        // console.log("likedBy -> ideaId", ideaId);
                        axios.get('/secure/dashboard/all-likes-by-users/'+ideaId).then((response) => {
                            // console.log("likedBy -> response.data", response.data.user_likes);
                            // this.loading = false;
                            this.user_likes =  response.data.user_likes ; 
                            this.total_likes =  response.data.total_likes ; 
                            let element = this.$el.querySelector('#likeModal');
                            $(element).modal('show');
                        }).catch((err) => {
                            console.log(err.response);
                        });

                    },
					ideaRating() {
                        // console.log({
                        //     is_featured: this.is_featured,
                        //     is_sponsored: this.is_sponsored,
                        //     idea_id: this.ideaId,
                        //     shortlist_id: this.shortlist_id,
                        // });
                        axios.post('/secure/dashboard/idea-feedback',{
                            is_featured: this.is_featured,
                            is_sponsored: this.is_sponsored,
                            idea_id: this.ideaId,
                            shortlist_id: this.shortlist_id,
                        })
                            .then(res => {
                            console.log("TCL: ideaRating -> res", res)
                                if (res.data.data) {
                                    // this.is_sponsored = res.data.is_sponsored;
                                    // console.log("TCL: ideaRating -> is_sponsored", this.is_sponsored)
                                    // this.is_featured = res.data.is_featured;
                                    // console.log("TCL: ideaRating -> is_featured", this.is_featured)
                                    this.ratingSubmitSuccess = 'Feedback Submission is Successful for this Idea.';
                                    setTimeout(() => this.elementVisible = false, 1500);
                                    this.elementVisible = true;
                                } else {
                                    this.ratingSubmitSuccess = 'Updated your Feedback Successfully for this Idea.';
                                    setTimeout(() => this.elementVisible = false, 3000);
                                    this.elementVisible = true;
                                }
                            })
                            .catch(res => console.log(err))
						// axios.post('/secure/dashboard/idea-rating', {
						// 	rating: this.ratingValue,
						// 	idea_id: this.uuid,
						// }).then((response) => {
						// 	this.ratingValue = '';
						// 	this.ratings.push(response.data);
						// 	this.ratingSubmitSuccess = 'Rating Submission was Successful for this Idea.';
						// 	setTimeout(() => this.elementVisible = false, 1500);
						// 	this.elementVisible = true;
						// }).catch((err) => {
						// 	console.log(err.response.data);
						// });
					},
					intervalFetchData: function() {
						setInterval(() => {
							this.created();
						}, 3000);
					},
					isLiked(id) {
						let liked = false;

						if (this.likes != []) {
							this.likes.forEach(element => {
								if (element.user_id == id) {
									liked = true;
								}
							});
						}
						return liked;
					},
				},
				mounted() {
					// Run the functions once when mounted
					this.created();
					// Run the intervalFetchData function once to set the interval time for later refresh
					this.intervalFetchData();
				},

			});

// 			window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
    </script>
@endsection
