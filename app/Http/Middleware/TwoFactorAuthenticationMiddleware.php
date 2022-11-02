<?php

namespace App\Http\Middleware;

use App\Mail\TwoFactorAuthenticationMail;
use App\Notifications\TwoFactorAuthentication;
use Carbon\Carbon;
use Closure;
use Keygen\Keygen;

class TwoFactorAuthenticationMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param $request
	 * @param  \Closure  $next
	 *
	 * @return \Illuminate\Http\RedirectResponse|mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = auth()->user();
		if ($user->two_factor_auth_expiry > Carbon::now()) {
			return $next($request);
		}

		$user->two_factor_auth_token = strtoupper(Keygen::numeric(7)->generate());
		$user->save();

		$user->notify(new TwoFactorAuthentication($user->uuid, $user->two_factor_auth_token));

		return redirect()->route('two_factor_authentication.index');
	}
}
