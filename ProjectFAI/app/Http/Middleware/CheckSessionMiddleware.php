<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('id_user')) {
            return redirect('/')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}
