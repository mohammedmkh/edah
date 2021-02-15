<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class mainAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'mainAdmin')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
