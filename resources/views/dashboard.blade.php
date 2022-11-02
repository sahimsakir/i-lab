@extends('layouts.app')

@section('site_title', 'Home')

@section('bg_image', 'home-page full-height')

@section('content')



  @php $agent = new Jenssegers\Agent\Agent(); @endphp

  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
      {!! laraflash()->render() !!}
    </div>
    <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
  </div>
  <!-- /.row -->

  <div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
      <div class="row mb-4">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 @if ($agent->isMobile()) mb-4 @endif card-margin-bottom">
          <div class="col-card-design-blue">
            <div class="card card-design-blue">
              <div class="row">
                <div class="col-5 col-sm-5 col-md-5 col-lg-5 column-01-wrapper">
                  <div class="column-01">{{ $totalIdeasCount }}</div>
                  <!-- /.column-01 -->
                </div>
                <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->

                <div class="col-7 col-sm-7 col-md-7 col-lg-7 column-02-wrapper">
                  <div class="row">
                    <div class="col-3 col-sm-3 col-md-3 col-lg-3 column-02 text-center">
                      <img src="{{ asset('img/submitted-icon.svg') }}" alt="" height="55"></div>
                    <!-- /.col-4 col-sm-4 col-md-4 col-lg-4 -->

                    <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                      <div class="column-02">No. of Idea <br> submitted</div>
                      <!-- /.column-02 -->
                    </div>
                    <!-- /.col-8 col-sm-8 col-md-8 col-lg-8 -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card card-design-blue -->
          </div>
          <!-- /.col-card-design-blue -->
        </div>
        <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->

        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
          <div class="col-card-design-purple">
            <div class="card card-design-purple">
              <div class="row">
                <div class="col-5 col-sm-5 col-md-5 col-lg-5 column-01-wrapper">
                  <div class="column-01">
                    {{-- This is temporary cause piloted need to ZERO manually [un-comment]--}}
                    {{ App\Idea::whereIsActive(1)->whereIsSubmitted(1)->whereIsPiloted(1)->count() }}
                    {{-- 0 --}}
                  </div>
                  <!-- /.column-01 -->
                </div>
                <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->

                <div class="col-7 col-sm-7 col-md-7 col-lg-7 column-02-wrapper">
                  <div class="row">
                    <div class="col-3 col-sm-3 col-md-3 col-lg-3 column-02 text-center">
                      <img src="{{ asset('img/featured-icon.svg') }}" alt="" height="55"></div>
                    <!-- /.col-4 col-sm-4 col-md-4 col-lg-4 -->

                    <div class="col-9 col-sm-9 col-md-9 col-lg-9">
                      <div class="column-02">No. of ideas <br> piloted</div>
                      <!-- /.column-02 -->
                    </div>
                    <!-- /.col-8 col-sm-8 col-md-8 col-lg-8 -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card card-design-blue -->
          </div>
          <!-- /.col-card-design-purple -->
        </div>
        <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->
      </div>
      <!-- /.row -->

      <div class="row mobile-view-margin">
        <div class="col-12 col-sm-12 col-sm-12 col-lg-12 @if ($agent->isMobile()) mb-4 @endif">
          <div class="card card-shadow p-3">
            <h5 class="text-deep-purple mb-0">
              Recent Ideas &nbsp;&nbsp;&nbsp;
              <!--<span class="badge badge-purple badge-pill">{{ $recentIdeasCount }}</span>-->

              {{-- <span class="mr-3" style="float: right">{{date('M-y')}}</span> --}}

            </h5>
            <hr class="hr">

            <div v-if="loading" class="text-center">
              <div class="lds-facebook">
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>

            <div class="enable-ideas-scrollable" style="display:none" :style="loading == true ? 'display:none' : 'display:inline'">
              <ul class="list-unstyled recent-ideas-module pt-0 pb-1" v-for="(idea, index) in ideas" :key="index">
                <li class="media hr pb-0 mb-2 mt-2">


                  <div v-if="idea.user.profile_picture == undefined">
                    <a :href="'/secure/dashboard/idea/' + idea.uuid">
                      <img src="{{asset('/img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" alt="Profile Picture" height="60">
                    </a>
                  </div>

                  <div v-else>
                    <a :href="'/secure/dashboard/idea/' + idea.uuid">
                      <img :src="'{{asset('/')}}' + idea.user.profile_picture" class="mr-2 rounded-circle" alt="Profile Picture" height="60">
                    </a>
                  </div>

                  <div class="media-body recent-ideas-idea-description">
                    <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                      <a :href="'/secure/dashboard/idea/' + idea.uuid">@{{ idea.title }}<span class="text-muted">|</span> @{{ idea.topic }}</a>
                      <span v-if="idea.is_piloted == 1" class="badge piloted">P</span>
                    </h5>

                    <div class="row">
                      <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                        <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">@{{ idea.user.first_name }}, @{{ idea.user.designation
                          }}</p>
                      </div>
                      <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                      <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                        <span v-if="idea.is_featured == 1"><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt=""></span></span>
                        <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
                      </div>
                      <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                    </div>
                    <!-- /.row -->

                    <p style="color: #414141;display:inline" :id="idea.id+'viewMoreText'">@{{ idea.elevator_pitch | truncate(160, '...') }}</p>
                    <p style="color: #414141;display:none" :id="idea.id+'viewLessText'">@{{ idea.elevator_pitch }}</p>

                    {{-- <div class="text-right"><a @click="expandID === '' ? expandID = idea.uuid : expandID = ''" class="view-more-button">View More</a></div>
                    <!-- /.text-right --> --}}
                    <br>
                    <div class="row" style="display: flex; font-size: 11px;">
                      <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <div>
                          <span class="mr-2" style="color: #7B7B7B;">@{{ idea.comments.length }}</span> comments
                          {{-- <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2"> --}}

                          <a href="javascript:void(0)" @click="likedBy(idea.id)" >
                            <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{idea.likes.length}} likes</span>
                          </a>

                          <span v-if="isLiked(idea.likes, {{Auth::user()->id}})">
                                                        <img :id="idea.id" @click="like(idea.id);" src="{{ asset('img/like.svg') }}" class="like-btn"
                                                             height="16" alt="">
                                                    </span>
                          <span v-else>
                                                        <img :id="idea.id+'-grey'" @click="like(idea.id)" src="{{ asset('img/like_gray.svg') }}"
                                                             class="like-btn" height="16" alt="">
                                                    </span>
                        </div>
                      </div>
                      <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                      {{-- <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                          <div class="text-right">
                              <a :href="'/secure/dashboard/idea/' + idea.uuid" class="view-more-button" style="font-size: 11px;">Full View</a>
                          </div>
                          <!-- /.text-right -->
                      </div> --}}

                      <div v-if="idea.elevator_pitch.length > 160"
                           class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="text-right">
                          <div class="text-right">
                            <a :id="idea.id+'viewMore'" style="display:inline" @click="seeMoreOrLess(idea.id+'viewMore', idea.id)" class="view-more-button">See
                              More</a>
                            <a :id="idea.id+'viewLess'" style="display:none" @click="seeMoreOrLess(idea.id+'viewLess', idea.id)" class="view-more-button">See
                              Less</a>
                          </div>
                        </div>
                        <!-- /.text-right -->
                      </div>
                      <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                    </div>
                    <!-- /.row -->
                  </div>
                </li>
              </ul>
            </div>
            <!-- /.enable-ideas-scrollable -->

          </div>
          <!-- /.card card-shadow -->
        </div>
        <!-- /.col-12 col-sm-12 col-sm-12 col-lg-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col-12 col-sm-12 col-md-8 col-lg-8 -->

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 mobile-view-margin">
      <div class="row @if ($agent->isMobile()) mb-4 @else mb-3 @endif">
        <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
          <div class="card card-shadow p-3">
            <h5 class="text-deep-purple mb-0">Featured Ideas &nbsp;&nbsp;&nbsp;<span
                class="badge badge-purple badge-pill">{{ App\Idea::whereIsActive(1)->whereIsSubmitted(1)->whereIsFeatured(1)->count() }}</span>
            </h5>
            <hr class="hr">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
              <div class="carousel-inner">
                @unless (empty($featuredIdeas))
                  @foreach ($featuredIdeas as $featuredIdea)
                    @if ($loop->first)
                      <div class="carousel-item active">
                        <ul class="list-unstyled featured-ideas-module pt-0 pb-1">
                          <li class="media hr pb-0 mb-2 mt-2">
                            <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">
                              @if($featuredIdea->user->profile_picture != null )
                                <img src="{{ asset($featuredIdea->user->profile_picture) }}" class="mr-2 rounded-circle" alt="Profile Picture" height="60">
                              @else
                                <img src="{{asset('img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" alt="Profile Picture" height="60">
                              @endif
                            </a>
                            <div class="media-body recent-ideas-idea-description">
                              @if ($featuredIdea->is_featured === 1)
                                <span><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt="Featured"></span></span>
                              @endif

                              <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                                <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">{{ $featuredIdea->title }}
                                  <span class="text-muted">|</span> {{ $featuredIdea->topic }}</a>
                              </h5>

                              <div class="row">
                                <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                  <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">{{ $featuredIdea->user->first_name }}
                                    , {{ $featuredIdea->user->designation }}</p>
                                </div>
                                <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                  <small class="recent-ideas-idea-published-time"
                                         style="color: #B9B9B9;">{{ Carbon\Carbon::parse($featuredIdea->submitted_at)->diffForHumans() }}</small>
                                </div>
                                <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                              </div>
                              <!-- /.row -->

                              <p style="color: #414141;">{{ Illuminate\Support\Str::limit($featuredIdea->elevator_pitch,'150') }}</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    @else
                      <div class="carousel-item">
                        <ul class="list-unstyled recent-ideas-module pt-0 pb-1">
                          <li class="media hr pb-0 mb-2 mt-2">
                            <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">
                              @if($featuredIdea->user->profile_picture != null)
                                <img src="{{ asset($featuredIdea->user->profile_picture) }}" class="mr-2 rounded-circle" alt="Profile Picture" height="60">
                              @else
                                <img src="{{asset('img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" alt="Profile Picture" height="60">

                              @endif

                            </a>
                            <div class="media-body recent-ideas-idea-description">
                              <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                                <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">{{ $featuredIdea->title }}
                                  <span class="text-muted">|</span> {{ $featuredIdea->topic }}</a>
                              </h5>

                              <div class="row">
                                <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                  <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">{{ $featuredIdea->user->first_name }}
                                    , {{ $featuredIdea->user->designation }}</p>
                                </div>
                                <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                  @if ($featuredIdea->is_featured === 1)
                                    <span><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt="Featured"></span></span>
                                  @endif

                                  <small class="recent-ideas-idea-published-time"
                                         style="color: #B9B9B9;">{{ Carbon\Carbon::parse($featuredIdea->submitted_at)->diffForHumans() }}</small>
                                </div>
                                <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                              </div>
                              <!-- /.row -->

                              <p style="color: #414141;">{{ Illuminate\Support\Str::limit($featuredIdea->elevator_pitch,'150') }}</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    @endif
                  @endforeach
                @endunless
              </div>

              <div class="text-right"><a href="{{ route('dashboard.featured-ideas') }}" class="btn btn-purple btn-sm rounded-pill">View All</a>
              </div>

              <div class="clearfix mb-2"></div>
              <!-- /.clearfix -->

              <ol class="carousel-indicators carousel-indicators-custom">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                  <img src="{{ asset('img/dot-and-circle.svg') }}" alt="" height="16"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1">
                  <img src="{{ asset('img/dot-and-circle.svg') }}" alt="" height="16"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2">
                  <img src="{{ asset('img/dot-and-circle.svg') }}" alt="" height="16"></li>
              </ol>
            </div>
          </div>
          <!-- /.card card-shadow -->
        </div>
        <!-- /.col-12 col-sm-12 col-sm-12 col-lg-12 -->
      </div>
      <!-- /.row mb-3 -->

      @if (App\Idea::whereUserId(auth()->id())->doesntExist())
        <div class="row mb-3">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card card-shadow p-3">
              <div class="row">
                <div class="col-12 col-sm-9 col-md-9 col-lg-9">
                  <h5 class="text-deep-purple mb-0">Hi {{ auth()->user()->first_name }}, it’s Easy to submit an idea</h5>
                  <!-- /.text-deep-purple mb-0 -->
                </div>
                <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->

                <div class="col-12 col-sm-3 col-md-3 col-lg-3 text-right">
                  <a href="{{ route('dashboard.idea.create') }}" class="btn btn-purple btn-sm">Submit</a>
                </div>
                <!-- /.col-12 col-sm-3 col-md-3 col-lg-3 text-right -->
              </div>
              <!-- /.row -->

              <hr class="hr">
              <!-- /.hr -->

              <div class="mb-3">
                <img src="{{ asset('img/idea-submission-steps.svg') }}" alt="" class="img-fluid">
                <!-- /.img-fluid -->
              </div>
              <!-- /.mb-4 -->

              <div class="idea-submission-steps mb-1">
                <h5 style="color: #607D8C">Step 1</h5>
                <p>Login to the website and select a topic.</p>
              </div>
              <!-- /.idea-submission-steps mb-1 -->

              <div class="idea-submission-steps mb-1">
                <h5 style="color: #9982FD">Step 2</h5>
                <p>Write your idea in your own words. Attach supporting documents if you have (e.g. PPT file, images etc.)</p>
              </div>
              <!-- /.idea-submission-steps mb-1 -->

              <div class="idea-submission-steps mb-1">
                <h5 style="color: #00BAD6">Step 3</h5>
                <p>Submit your idea or save it as ‘Draft’. You can always edit the drafts anytime you want. Drafts can be submitted later.</p>
              </div>
              <!-- /.idea-submission-steps mb-1 -->
            </div>
            <!-- /.card card-shadow p-3 -->
          </div>
          <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
        </div>
        <!-- /.row mb-3 -->
      @else
        <div class="row mb-3">
          <div class="col-12 col-sm-12 col-sm-12 col-lg-12">
            <div class="card card-shadow p-3">
              <h5 class="text-deep-purple font-weight-bold mb-0">MY IDEAS &nbsp;&nbsp;&nbsp;<span
                  class="badge badge-purple badge-pill">{{ App\Idea::whereUserId(auth()->id())->count() }}</span>
              </h5>
              <hr class="hr">

              @unless (empty($myIdeaDrafted))
                <div class="my-idea-drafted mb-2">
                  <strong style="color: #FFAD4D; font-size: 16px;">Drafts</strong>

                  <h6 class="text-uppercase font-weight-normal mt-2" style="color: #5A5A5A">{{ $myIdeaDrafted->title }} | {{ $myIdeaDrafted->topic }}</h6>

                  <p style="color: #414141">{{ Illuminate\Support\Str::words($myIdeaDrafted->elevator_pitch,'25') }}</p>

                  <div class="text-right">
                    <a href="{{ route('dashboard.my-drafted-ideas') }}" class="btn btn-purple btn-sm rounded-pill" style="font-size: 12px;">View All</a>
                  </div>
                  <!-- /.text-right -->
                </div>
                <!-- /.my-idea-drafted mb-2 -->
              @endunless

              @unless (empty($myIdeaSubmitted))
                <div class="my-idea-submitted mb-2">
                  <strong style="color: #FFAD4D; font-size: 16px;">Submitted</strong>

                  <h6 class="text-uppercase font-weight-normal mt-2" style="color: #5A5A5A">{{ $myIdeaSubmitted->title }} | {{ $myIdeaSubmitted->topic }}</h6>

                  <p class="mb-0" style="color: #414141">{{ Illuminate\Support\Str::words($myIdeaSubmitted->elevator_pitch,'25') }}</p>

                  <div class="text-right">
                    <a href="{{ route('dashboard.idea.index') }}" class="btn btn-purple btn-sm rounded-pill" style="font-size: 12px;">View All</a>
                  </div>
                  <!-- /.text-right -->
                </div>
                <!-- /.my-idea-submitted mb-2 -->
              @endunless
            </div>
            <!-- /.card card-shadow -->
          </div>
          <!-- /.col-12 col-sm-12 col-sm-12 col-lg-12 -->
        </div>
      @endif
    </div>
    <!-- /.col-12 col-sm-12 col-md-4 col-lg-4 -->


    @include('modals.like_modal');


  </div>
  <!-- /.row -->
@endsection

@section('customJS')
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

  <script>
    Vue.config.devtools = true;

    function seeMoreOrLess(domId, id) {
      // console.log(domId, id);
      if (domId == id + 'viewMore') {
        // console.log(document.getElementById(id+'viewLess').style.display);

        document.getElementById(domId).style.display = 'none';
        document.getElementById(id + 'viewLess').style.display = 'inline';
        document.getElementById(id + 'viewLess').style.display = 'inline';

        document.getElementById(id + 'viewMoreText').style.display = 'none';
        document.getElementById(id + 'viewLessText').style.display = 'inline';
        // document.getElementById(`${id}`).style.display = "none";
      } else {
        document.getElementById(domId).style.display = 'none';
        document.getElementById(id + 'viewMore').style.display = 'inline';

        document.getElementById(id + 'viewMoreText').style.display = 'inline';
        document.getElementById(id + 'viewLessText').style.display = 'none';
      }
    }

    const app = new Vue({
      el: '#app',
      data() {
        return {
          ideas: [],
          readMore: false,
          expandID: '',
          loading: true,
          like_gray_animate: true,

          // modal of likes: 
          user_likes: [],
          total_likes: 0,
        };
      },
      methods: {
        getIdea() {
          axios.get('/secure/dashboard/recent-idea-published').then((response) => {
            this.ideas = response.data.ideas;
            this.loading = false;
            //console.log(response.data);
          }).catch((err) => {
            console.log(err.response);
          });
        },
        like(ideaId) {


          axios.post(`/secure/dashboard/submit-like`, { idea_id: ideaId }).then((response) => {
            this.getIdea();

            //console.log(response.data);
          }).catch((err) => {
            console.log(err);
          });
        },
        intervalFetchData: function() {
          setInterval(() => {
            this.getIdea();
          }, 3500);
        },
        isLiked(idea, id) {

          let liked = false;

          idea.forEach(element => {
            if (element.user_id == id) {
              liked = true;
            }
          });
          return liked;
        },
        immediateChange(id) {
          // console.log(this.$el.querySelector(`#${id}`));
          // (this.$ref +`.${id}.`+ style.display) = none;
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

        }
      },
      mounted() {
        // Run the functions once when mounted
        this.getIdea();
        // Run the intervalFetchData function once to set the interval time for later refresh
        this.intervalFetchData();
      },
      created() {
        this.getIdea();

        /*Echo.channel('idea').listen('NewComment', (e) => {
          this.comments.push({
            comment: e.comment,
          });
        });*/
      }
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

   // window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
  </script>
@endsection
