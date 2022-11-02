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
</head>
<body class="@yield('bg_image')">
<div id="app">
    <div class="container-fluid py-5">
        @yield('content')
    </div>

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
