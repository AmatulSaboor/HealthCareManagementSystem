<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, int $role)
    {
        if (Auth::check() && Auth::user()->role_id == $role) {
            return $next($request);
        }
        return abort(404);
    }
}