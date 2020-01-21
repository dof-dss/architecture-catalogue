<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Log;

class LogRoute
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
        Log::info($request->method() . ": " . $request->fullUrl());

        return $next($request);
    }
}
