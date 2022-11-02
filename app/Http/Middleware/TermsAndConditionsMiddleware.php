<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TermsAndConditionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  null  $guard
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->check() && auth()->guard($guard)->user()->tnc_accepted != true) {
            return redirect()->route('terms.show');
        }

        return $next($request);
    }
}
