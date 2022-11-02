@extends('layouts.app')

@section('site_title', 'Featured Ideas')

@section('bg_image', 'featured-ideas-page full-height')

@section('content')
    <div class="row">

        <div v-if="loading" class="text-center col-12 col-sm-12 col-md-7 offset-md-1 col-lg-7 offset-lg-1">
            <div class="lds-facebook"><div></div><div></div><div></div></div>
        </div>

        <div v-else class="col-12 col-sm-12 col-md-7 offset-md-1 col-lg-7 offset-lg-1" style="display:none" :style="loading == true ? 'display:none' : 'display:block'">
            <ul class="list-unstyled recent-ideas-module pt-0 pb-1" v-for="(idea, index) in ideas" :key="index">
                <li class="media hr pb-0 mb-2 mt-2">

                    <div v-if="idea.user.profile_picture == undefined">
                        <a :href="'/secure/dashboard/idea/' + idea.uuid"><img src="/img/profile-picture-placeholder.svg" class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
                    </div>

                    <div v-else>
                        <a :href="'/secure/dashboard/idea/' + idea.uuid"><img :src="'{{asset('/')}}' + idea.user.profile_picture" class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
                    </div>

                    <div class="media-body recent-ideas-idea-description">
                        <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                            <a :href="'/secure/dashboard/idea/' + idea.uuid">@{{ idea.title }}<span class="text-muted">|</span> @{{ idea.topic }}</a>
                            <span v-if="idea.is_piloted == 1" class="badge piloted">P</span>
                        </h5>

                        <div class="row">
                            <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">@{{ idea.user.first_name }}, @{{ idea.user.designation }}</p>
                            </div>
                            <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                <span v-if="idea.is_featured == 1"><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt=""></span></span>
                                <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
                            </div>
                            <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                        </div>
                        <!-- /.row -->

                        <p style="color: #414141;">@{{ idea.elevator_pitch | truncate(160, '...') }}</p>

                        {{--<div class="text-right"><a href="#" class="view-more-button">View More</a></div>
                        <!-- /.text-right -->--}}

                        <div class="row" style="display: flex; font-size: 11px;">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div>
                                    <span class="mr-2" style="color: #7B7B7B;">@{{ idea.comments.length }}</span> comments
                                    {{-- <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2"> --}}
                                    {{-- <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{idea.likes.length}} likes</span> --}}
                                    <a href="javascript:void(0)" @click="likedBy(idea.id)" >
                                        <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{idea.likes.length}} likes</span>
                                    </a>
									{{-- <img @click="like(idea.id)" src="{{ asset('img/like.svg') }}" height="16" alt=""> --}}
									<span v-if="isLiked(idea.likes, {{\Illuminate\Support\Facades\Auth::user()->id}})">
										<img id="idea.id" class="like-btn" @click="like(idea.id)" src="{{ asset('img/like.svg') }}" height="16" alt="">
									</span>
									<span v-else>
										<img id="idea.id+'-grey'" class="like-btn" @click="like(idea.id)" src="{{ asset('img/like_gray.svg') }}" height="16" alt="">
									</span>
                                </div>
                            </div>
                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-right">
                                    <a :href="'/secure/dashboard/idea/' + idea.uuid" class="view-more-button" style="font-size: 11px;">Full View</a></div>
                                <!-- /.text-right -->
                            </div>
                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                        </div>
                        <!-- /.row -->
                    </div>
                </li>
            </ul>
        </div>
		<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->

        <div class="filter" style="display:none" :style="loading == true ? 'display:none' : 'display:block'">
            <div class="filter__tabs row">
                <div id="tab" class="row" style="visibility:visible">
                    {{-- <div id="date">
                        <vuejs-datepicker
                            input-class="form-control custom-form-control filter__date"
                            placeholder="Select Date"
                            ranges
                            ></vuejs-datepicker>
                    </div> --}}
                    <div>
                        <input type="text" name="date" id="demo-1" v-model="dateField" @focus="CallDatePicker()" class="form-control custom-form-control filter__date" placeholder="Date">
                    </div>
                    <div>
                        <select name="topic" class="custom-form-control filter__select" v-model="topicField" @change="filterAllIdea(dateField)" title="Topic">
                            <option value="all-idea">All Featured Ideas</option>
                            <option value="Distribution">Distribution</option>
                            <option value="Consumer Engagement">Consumer Engagement</option>
                            <option value="B2B">B2B</option>
                            <option value="Automation">Automation</option>
                            <option value="Merchandising">Merchandising</option>
                            <option value="FF">FF</option>
                            <option value="Research">Research</option>
                            <option value="Channel Management">Channel Management</option>
                            <option value="Product">Product</option>
                            <option value="Pricing and Compliance">Pricing and Compliance</option>
                            <option value="Sales Management">Sales Management</option>
                            <option value="Illicit">Illicit</option>
                            <option value="New Category">New Category</option>
                            <option value="Alternative Revenue">Alternative Revenue</option>
                            <option value="Culture and Way of Work">Culture and Way of Work</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div>
                        <select name="uname" class="custom-form-control filter__name" v-model="nameField" @change="filterAllIdea(dateField)" title="Name">
                            <option value="all-idea">All Featured Ideas</option>

                            @foreach ($users as $user)
                                <option value="{{$user['uuid']}}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div v-if="users.length">
                        <select name="uname" class="form-control custom-form-control filter__name" v-model="nameField" data-live-search="true" @change="filterAllIdea(dateField)" title="Name">
                            <option v-for="user in getUser" :value="user.uuid">@{{ user.name }}</option>
                        </select>
                    </div> --}}
                </div>
                <a class="filter__btn" onclick="toggleClass()" style="font-size: 11px; margin-left: 25px; margin-top: 2px; cursor:pointer">
                    <img src="{{asset('img/filter.png')}}" alt="Logo" height="32">
                </a>
            </div>
        </div>

        @include('modals.like_modal');



		<link rel="stylesheet" type="text/css" href="{{URL::asset('datepicker-css/lightpick.css')}}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="{{URL::asset('datepicker-js/lightpick.js')}}"></script>
    </div>
    <!-- /.row -->
@endsection

@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
	<script>
        function toggleClass(){
            let currDisplay = document.getElementById("tab").style.visibility;
            if (currDisplay === 'hidden') {
                document.getElementById("tab").style.visibility = "visible";
            }else{
                document.getElementById("tab").style.visibility = "hidden";
            }
        }
    </script>
    <script>
			Vue.config.devtools = true;

			const app = new Vue({
				el: '#app',
				data() {
					return {
						ideas: [],
						dateField: [],
                        topicField: '',
                        nameField: '',
                        filteredData: false,
                        AIFlag: 0,
                        loading: true,
                        users: [],

                        // modal of likes: 
                        user_likes: [],
                        total_likes: 0,
					};
                },
                computed: {
                    getUser(){
                        return this.users;
                    }
                },
				methods: {
					getIdea() {
						axios.get('/secure/dashboard/all-piloted-ideas-published').then((response) => {
							this.ideas = response.data.ideas;
                            if (this.users.length) {
                                this.loading = false;
                            }
							// console.log(response.data);
						}).catch((err) => {
							console.log(err.response);
						});
                    },
                    getUsername(){
                        axios.get('/secure/dashboard/allusername').then((response) => {
                            this.users = response.data.users;
							// console.log(response.data.users);
						}).catch((err) => {
							console.log(err.response);
						});
                    },
					like(ideaId) {
						axios.post(`/secure/dashboard/submit-like`, {idea_id: ideaId}).then((response) => {
							this.getIdea();

							console.log(response.data);
						}).catch((err) => {
							console.log(err);
						});
					},
					intervalFetchData: function() {
						let timer = setInterval(()=>{
                            if (!this.AIFlag) {
                                this.getUsername();
                                this.getIdea();

                            }
                        }, 10000);
                        if(this.filteredData){
                            // console.log("called");
                            clearInterval(timer);
                            this.AIFlag = 1;
                        }
					},
					isLiked(idea, id){

						let liked = false;

						idea.forEach(element => {
							if (element.user_id == id) {
								liked = true;
							}
						});
						return liked;
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

					CallDatePicker(){
                        let myThis = this;
                        var picker = new Lightpick({
                        field: document.getElementById('demo-1'),
                        singleDate: false,
                        autoClose:true,
                        selectForward: false,
                        format: 'MM/DD/YYYY',
                        // minDate: moment().startOf('month').add(7, 'day'),
                        maxDate: moment().endOf('month').subtract(7, 'day'),
                        onSelect: function(start, end){
                            date = document.getElementById('demo-1').value;
                            this.dateField = date.split("-");
                            console.log(this.dateField[1])
                            if (this.dateField[1] != " ...") {
                                myThis.filterAllIdea(this.dateField);
                            }
                        }
                        });
                    },
					filterAllIdea(datePickerData=null){


                        if(this.topicField == "all-idea" || this.nameField == "all-idea")
                        {
                            window.location = '/secure/dashboard/featured-ideas';
                        }

                        if(this.dateField != datePickerData){
                            this.dateField = datePickerData;
                        }

                        // console.log("called", datePickerData.length);
                        const data = {};


                        if (this.dateField.length == 2 && this.topic != '' && this.nameField != '') {
                            data.start = this.dateField[0];
                            data.end = this.dateField[1];
                            data.topic = this.topicField;
                            data.uuid = this.nameField;
                        }//3select
                        else if (this.dateField.length == 2 && this.topic == '' && this.nameField != '') {
                            data.start = this.dateField[0];
                            data.end = this.dateField[1];
                            data.topic = null;
                            data.uuid = this.nameField;
                        }//date&name
                        else if (this.dateField.length == 2 && this.topic != '' && this.nameField == '') {
                            data.start = this.dateField[0];
                            data.end = this.dateField[1];
                            data.topic = this.topicField;
                            data.uuid = null;
                        }//date&topic
                        else if (this.dateField.length != 2 && this.topic != '' && this.nameField != '') {
                            data.start = null;
                            data.end = null;
                            data.topic = this.topicField;
                            data.uuid = this.nameField;
                        }//topic&name
                        else if (this.dateField.length == 2 && this.topic == '' && this.nameField == '') {
                            data.start = this.dateField[0];
                            data.end = this.dateField[1];
                            data.topic = null;
                            data.uuid = null;
                        }//only date
                        else if (this.dateField.length != 2 && this.topic != '' && this.nameField == '') {
                            data.start = null;
                            data.end = null;
                            data.topic = this.topicField;
                            data.uuid = null;
                        }//only topic
                        else {
                            data.start = null;
                            data.end = null;
                            data.topic = null;
                            data.uuid = this.nameField;
                        }//only name

                        console.log(data);
                        axios.post('/secure/dashboard/filter-all-featured-ideas-published', {
                            start: data.start,
                            end: data.end,
                            topic: data.topic,
                            uuid: data.uuid
                        }).then((response) => {
                            this.ideas = response.data.ideas;
                            this.filteredData = response.data.ideas;

                            this.intervalFetchData();

                            // console.log(data);
                            // console.log(response.data);
                        }).catch((err) => {
                            console.log(err.response);
                        });
                    }
				},
				mounted() {
                    this.getUsername();

					// Run the functions once when mounted
					this.getIdea();
					// Run the intervalFetchData function once to set the interval time for later refresh
					this.intervalFetchData();
				},
				created() {
                    this.getUsername();
					this.getIdea();

					Echo.channel('idea').listen('NewComment', (e) => {
						this.comments.push({
							comment: e.comment,
						});
					});
				},
			});

			Vue.filter('formatDate', function(value) {
				if (value) {
					return moment(String(value)).fromNow();
				}
			});

			const filter = function(text, length, clamp) {
				clamp = clamp || '...';
				var node = document.createElement('div');
				node.innerHTML = text;
				var content = node.textContent;
				return content.length > length ? content.slice(0, length) + clamp : content;
			};

			Vue.filter('truncate', filter);

			window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
    </script>
@endsection
