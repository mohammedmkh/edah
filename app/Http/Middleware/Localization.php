<?php

namespace App\Http\Middleware;

use Closure;

class Localization
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
        // return $next($request);
        if (session()->has('locale')) {
            \App::setLocale(session()->get('locale'));
        }

        //dd(session()->get('locale'));
        return $next($request);
    }
}
