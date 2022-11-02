<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('site_title', config('app.name'))</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
   
    <link href="{{asset('css/media-query.css')}}" rel="stylesheet">
    
    @yield('header_tag')
    
    <style>
    @media only screen and (max-width: 768px) {
    
        .mobile-view-margin{
            margin-bottom:20px !important;
            
        }
        
        .card-top-margin-for-mobile-view{
            margin-top:20px !important;
        }
      
      
      
    }
    
    @media only screen and (max-width: 580px) {
        .card-margin-bottom{
            margin-bottom:20px !important;
        }
    }

    
    
        
    </style>
</head>
<body class="@yield('bg_image')">
<div id="app">

    <nav class="navbar navbar-expand-md navbar-light custom-navbar-design bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard.index') }}"><img src="{{ asset('img/logo.png') }}"
                                                                               alt="Logo" height="55"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav justify-content-end d-flex flex-fill">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}" class="nav-link"><span
                                    @if (request()->is('secure/dashboard')) class="border-bottom-custom" @endif>Home</span></a>
                    </li>
                    <!-- /.nav-item -->

                    <li class="nav-item">
                        <a href="{{ route('dashboard.how-it-works') }}" class="nav-link"><span
                                    @if (request()->is('secure/dashboard/how-it-works')) class="border-bottom-custom" @endif>How It Works</span></a>
                    </li>
                    <!-- /.nav-item -->

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    @if (request()->is('secure/dashboard/all-idea') || request()->is('secure/dashboard/featured-ideas') || request()->is('secure/dashboard/piloted-ideas')) class="border-bottom-custom" @endif>Ideas</span></a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{ route('dashboard.featured-ideas') }}" class="dropdown-item">
                                <span @if (request()->is('secure/dashboard/featured-ideas')) class="border-bottom-custom" @endif>
                                    Featured Ideas
                                </span>
                            </a>
                            <a href="{{ route('dashboard.piloted-ideas') }}" class="dropdown-item">
                                <span @if (request()->is('secure/dashboard/piloted-ideas')) class="border-bottom-custom"  @endif>
                                    Piloted Ideas
                                </span>
                            </a>
                            
                            <div class="dropdown-divider"></div>

                            <a href="{{ route('dashboard.all-idea') }}" class="dropdown-item">
                                <span @if (request()->is('secure/dashboard/all-idea')) class="border-bottom-custom" @endif>
                                    All Ideas
                                </span>
                            </a>
                            
                        </div>
                    </li>
                    <!-- /.nav-item -->

                    <li class="nav-item idea-notification">
                        <a href="{{ route('dashboard.idea.index') }}" class="nav-link"><span
                                    @if (request()->is('secure/dashboard/idea') || request()->is('secure/dashboard/my-drafted-ideas') || request()->is('secure/dashboard/my-featured-ideas')) class="border-bottom-custom" @endif>My Ideas</span></a>

                        @if (App\Idea::whereUserId(auth()->id())->whereIsRead(false)->exists())
                            <span class="idea-notification-badge"><img src="{{ asset('img/idea-icon.svg') }}" height="18" alt=""></span>
                        @endif
                    </li>
                    <!-- /.nav-item -->

                    <li class="nav-item">
                        <a href="{{ route('dashboard.idea.create') }}" class="nav-link"><span
                                    @if (request()->is('secure/dashboard/idea/create')) class="border-bottom-custom" @endif>Submit Idea</span></a>
                    </li>
                    <!-- /.nav-item -->
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account.login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('account.register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                @if(Auth::user()->profile_picture != null)
                                    <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture"
                                         class="rounded-circle" width="45">
                                    <span class="caret"></span>
                                @else
                                    <img src="{{asset('/img/profile-picture-placeholder.svg')}}" alt="Profile Picture"
                                         class="rounded-circle" width="45">
                                    <span class="caret"></span>
                                @endif

                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <div class="dropdown-item">
                                    <p class="mb-0">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                    <span class="font-weight-lighter">{{ auth()->user()->designation }}</span>
                                </div>
                                <!-- /.dropdown-item -->
                                <div role="separator" class="dropdown-divider"></div>

                                <a href="{{ route('dashboard.my-profile') }}" class="dropdown-item">My Profile</a>
                                <!-- /.dropdown-item -->

                                <div role="separator" class="dropdown-divider"></div>

                                @hasanyrole('super_administrator|administrator|moderator|maintainer')
                                <a href="{{ route('admin.admin-dashboard') }}" class="dropdown-item">Admin Panel</a>
                                @endhasanyrole

                                <div role="separator" class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('account.logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                                <form id="logout-form" action="{{ route('account.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>


                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container -->
    </main>

    <script src="{{ mix('/js/app.js') }}"></script>

    <script>
			$.fn.selectpicker.Constructor.BootstrapVersion = 4;
    </script>

    <script>
			$(function() {
				$('select').selectpicker({
					actionsBox: true,
					liveSearch: true,
					width: '100%',
					selectedTextFormat: 'count > 3',
					showTick: true,
					size: 4,
				});
			});
    </script>

    @yield('customJS')

</div>
</body>
</html>
