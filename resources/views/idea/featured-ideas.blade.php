@extends('layouts.app')

@section('site_title', 'My Featured Ideas')

@section('bg_image', 'featured-ideas-page full-height')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row mb-4">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 @if ($agent->isMobile()) mb-3 @endif">
                    <a href="{{ route('dashboard.my-drafted-ideas') }}" style="text-decoration: none;">
                        <div class="draft-card-design {{ ($activeIdeaCard == 'drafted' ) ? 'active_ideaCard' : ''}}" style="filter:brightness(0.6)" >
                            <div class="draft-card">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-01-wrapper">
                                        <div class="column-01">
                                            <span class="column-01-item">{{ $draftedIdeasCount }}</span>
                                        </div>
                                        <!-- /.column-01 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-02-wrapper">
                                        <div class="column-02">
                                            <div class="mb-2">DRAFTED</div>

                                            <img src="{{ asset('img/drafted-icon.svg') }}" alt="Drafted Icon" height="35">
                                        </div>
                                        <!-- /.column-02 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.draft-card -->
                        </div>
                    </a>
                    <!-- /.draft-card-design -->
                </div>
                <!-- /.col-12 col-sm-6 col-md-3 col-lg-3 -->

                <div class="col-12 col-sm-6 col-md-3 col-lg-3 @if ($agent->isMobile()) mb-3 @endif">
                    <a href="{{ route('dashboard.idea.index') }}" style="text-decoration: none;">
                        <div class="submitted-card-design {{ ($activeIdeaCard == 'submitted' ) ? 'active_ideaCard' : ''}}" style="filter:brightness(0.6)">
                            <div class="submitted-card">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-01-wrapper">
                                        <div class="column-01">
                                            <span class="column-01-item">{{ $submittedIdeasCount }}</span>
                                        </div>
                                        <!-- /.column-01 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-02-wrapper">
                                        <div class="column-02">
                                            <div class="mb-2">SUBMITTED</div>

                                            <img src="{{ asset('img/submitted-icon.svg') }}" alt="Submitted Icon" height="35">
                                        </div>
                                        <!-- /.column-02 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.draft-card -->
                        </div>
                    </a>
                    <!-- /.draft-card-design -->
                </div>
                <!-- /.col-12 col-sm-6 col-md-3 col-lg-3 -->

                <div class="col-12 col-sm-6 col-md-3 col-lg-3 card-top-margin-for-mobile-view @if ($agent->isMobile()) mb-3 @endif">
                    <a href="{{ route('dashboard.my-featured-ideas') }}" style="text-decoration: none;">
                        <div class="featured-card-design {{ ($activeIdeaCard == 'featured' ) ? 'active_ideaCard' : ''}}" >
                            <div class="featured-card">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-01-wrapper">
                                        <div class="column-01"><span class="column-01-item">{{ $featuredIdeas->count() }}</span></div>
                                        <!-- /.column-01 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 column-02-wrapper">
                                        <div class="column-02">
                                            <div class="mb-2">FEATURED</div>

                                            <img src="{{ asset('img/featured-icon.svg') }}" alt="Featured Icon" height="35">
                                            <!-- /.fluid -->
                                        </div>
                                        <!-- /.column-02 -->
                                    </div>
                                    <!-- /.col-12 col-sm-6 col-md-6 col-lg-6 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.draft-card -->
                        </div>
                    </a>
                    <!-- /.draft-card-design -->
                </div>
                <!-- /.col-12 col-sm-6 col-md-3 col-lg-3 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-12 col-sm-10 col-md-8 col-lg-8">
            {!! laraflash()->render() !!}

            <h4 class="text-deep-purple mb-0">My Featured Ideas</h4>
            <!-- /.text-deep-purple mb-0 -->

            <hr class="hr mb-3">
            <!-- /.hr -->

            @unless (empty($featuredIdeas))
                @foreach ($featuredIdeas as $featuredIdea)
                {{-- {{$featuredIdea}} --}}
                    <ul class="list-unstyled recent-ideas-module pt-0 pb-1">
                        <li class="media hr pb-0 mb-2 mt-2">
							<a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">
									@if($featuredIdea->user->profile_picture != null)
									<img src="{{ asset($featuredIdea->user->profile_picture) }}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
									@else
									<img src="{{asset('img/profile-picture-placeholder.svg')}}" class="mr-2 rounded-circle" height="50" alt="Profile Picture">
									@endif
								{{-- <img src="{{ asset($featuredIdea->user->profile_picture) }}" class="mr-2 rounded-circle" alt="Profile Picture" height="60"> --}}
							</a>
                            <div class="media-body recent-ideas-idea-description">
                                <div class="row">
                                    <div class="col-12 col-sm-9 col-md-9 col-lg-9">
                                        <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                                            <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}">{{ $featuredIdea->title }}
                                                <span class="text-muted">|</span> {{ $featuredIdea->topic }}</a>
                                        </h5>

                                        <div class="row">
                                            <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                                <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">{{ $featuredIdea->user->first_name }}, {{ $featuredIdea->user->designation }}</p>
                                            </div>
                                            <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                                @if ($featuredIdea->is_featured === 1)
                                                    <span><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt="Featured"></span></span>
                                                @endif

                                                <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">{{ Carbon\Carbon::parse($featuredIdea->created_at)->diffForHumans() }}</small>
                                            </div>
                                            <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                                        </div>
                                        <!-- /.row -->

                                        <p style="color: #414141;">{{ Illuminate\Support\Str::words($featuredIdea->elevator_pitch,'28') }}</p>

                                        <div class="row mt-2">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                                <span style="color: #00BAFF;">{{ $featuredIdea->comments->count() }} comments &nbsp;
                                                    {{-- <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="mr-3"> --}}
                                                </span><span style="color: #00BAFF;">{{ $featuredIdea->likes->count() }} likes &nbsp;
                                                    {{-- <img src="{{ asset('img/like.svg') }}" height="15" alt=""> --}}
                                                </span>
                                            </div>

                                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-right">
                                                <a href="{{ route('dashboard.idea.show', $featuredIdea->uuid) }}" class="view-more-button" style="font-size: 12px;">Full View</a>
                                            </div>
                                            <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->

                                    {{-- <div class="col-12 col-sm-3 col-md-3 col-lg-3 text-center">
                                        <div style="background-color: #DCFAF2; color: #414141;-webkit-box-shadow:0 0 10px 2px rgba(0,62,145,0.2);-moz-box-shadow:0 0 10px 2px rgba(0,62,145,0.2);box-shadow:0 0 10px 2px rgba(0,62,145,0.2); padding: 12px 15px; border-radius: 14px;font-weight: 600;font-size: 16px;margin-top: 50px;">Featured</div>
                                    </div> --}}
                                    <!-- /.col-12 col-sm-3 col-md-3 col-lg-3 -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </li>
                    </ul>
                @endforeach
            @endunless
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
