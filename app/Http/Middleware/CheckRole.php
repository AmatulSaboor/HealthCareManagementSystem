<?php

namespace App\Http\Middleware;

use Closure;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, int $role)
    {   
        if(\Auth::check() && \Auth::user()->role_id == $role){
            return $next($request);
        }
        return abort(404);
        // return response('page not found');
    }
}