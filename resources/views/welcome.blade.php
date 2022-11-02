<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

		@media only screen and (max-width: 600px) {
			.full-height {
				height: 80vh;
			}
		}
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('account.login'))
        <div class="top-right links">
            @auth
                <a href="{{ route('dashboard.index') }}">Home</a>
            @else
                <a href="{{ route('account.login') }}">Login</a>

                @if (Route::has('account.register'))
                    <a href="{{ route('account.register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="mb-4 text-center">
            <a href="{{ route('dashboard.index') }}"><img src="{{ asset('img/home_logo.png') }}" alt="" width="150"></a>
        </div>
        <h4 class="moment-datetime"></h4><br>
    </div>
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
			width: 'auto',
			selectedTextFormat: 'count > 3',
			showTick: true,
		});
	});
</script>

</body>
</html>
