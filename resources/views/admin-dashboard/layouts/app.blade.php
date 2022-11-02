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

<!-- Styles for Date filter -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('datepicker-css/lightpick.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="{{URL::asset('datepicker-js/lightpick.js')}}"></script>

    @yield('header_tag')

    <style>
    html{
        height: 100%
    }
    body{
        height: 100%;
    }
    .enable-ideas-scrollable{
        max-height: 89vh;
    }
    .date_picker{
        width: 200px;
        float:right;
    }
    </style>
</head>
<body class="@yield('bg_image')">
<div id="app">
    <div class="row">
        <div class="col-12 col-sm-4 col-md-2 col-lg-2">
            {{-- Include Left Sidebar --}}
            @include('admin-dashboard.layouts.left-sidebar')
        </div>
        <!-- /.col-12 col-sm-4 col-md-3 col-lg-3 -->

        <div class="col-12 col-sm-8 col-md-10 col-lg-10">
            @yield('content')
        </div>
        <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->
    </div>
    <!-- /.row -->

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
