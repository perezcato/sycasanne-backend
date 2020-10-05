<?php

namespace App\Http\Middleware\Configuration;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DbConfigMiddleware
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
        if(!connectToDatabaseFromRequest($request)){
            return response()->json([
                'error' => 'Database not set'
            ], Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }
}
