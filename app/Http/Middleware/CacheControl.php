<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cache-Control', 'private, max-age=0, no-cache');
        $response->headers->set('Expires', Carbon::now()->addDay()->format('r'));
        $response->headers->set('Last-Modified', Carbon::today()->format('r'));
        $response->headers->set('Vary', 'User-Agent');
        return $response;

    }
}
