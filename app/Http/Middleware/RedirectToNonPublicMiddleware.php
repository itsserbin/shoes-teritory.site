<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToNonPublicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $segments = explode('/', request()->route()->getPrefix());
        if ($segments[0] == 'public') {
            unset($segments[0]);
            return redirect()->secure(implode("/", $segments));
        }
        return $next($request);
    }
}
