<p>Login 2FA Code: {{ $two_factor_auth_token }}</p>

<p>IP Address: {{ request()->ip() }}</p>

<p>Time: {{ Carbon\Carbon::now()->format('F j, Y, g:i A') }}</p>