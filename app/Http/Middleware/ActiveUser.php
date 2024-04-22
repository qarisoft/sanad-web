<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        dd(auth()->user()->active());
        if (auth()->user()->active()  || auth()->user()->company()->get()->isEmpty()){
            return $next($request);
        }
        abort(404);

    }
}
