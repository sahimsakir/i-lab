<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403);
        }

        if (auth()->user()->is_active != 1) {
            auth()->logout();
            session()->flush();
            session()->regenerate();

            laraflash()->message('Your account is not active. Please contact the site administrator for further information.')->danger();

            return redirect()->route('account.login');
        }

        return $next($request);
    }
}
