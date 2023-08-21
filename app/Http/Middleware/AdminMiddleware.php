<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use HttpResponses;
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role === 'SuperAdmin'){
            
                return $next($request);
            }
            abort('error');
    }
}
