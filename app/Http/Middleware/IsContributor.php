<?php

namespace App\Http\Middleware;

use Closure;

class IsContributor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->isContributor()) {
            return $next($request);
        }
        abort(403, 'You are not authorised to perform this action.');
    }
}
