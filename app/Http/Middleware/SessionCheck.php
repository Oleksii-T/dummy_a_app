<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class SessionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (session('subscribe-after-auth') && !in_array($request->route()->getName(), ['website.profile', 'website.sign-up','website.login']) && $request->url() != url('register')) {
            session()->forget('subscribe-after-auth');
        }

        return $next($request);
    }
}
