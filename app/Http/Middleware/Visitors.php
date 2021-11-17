<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class Visitors
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
        $ip = $request->ip();
        $visitor = Visitor::whereDate('created_at', '>=', Carbon::now()->subDays(7))->where('ip', $ip)->first();

        if ($visitor) {
            return $next($request);
        }

        Visitor::create([
            'ip' => $ip
        ]);

        return $next($request);
    }
}
