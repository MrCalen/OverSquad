<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Response;
use JWTAuth;
use Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->admin !== 1) {
            return Redirect::to('/');
        }

        return $next($request);
    }
}
