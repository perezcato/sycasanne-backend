<?php

namespace App\Http\Middleware\Configuration;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VerifyUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->verifyUser($request)){
            return response()->json([
                'message' => 'unauthorized access'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    private function verifyUser(Request $request)
    {
        $user = DB::connection('mysql')
            ->table('user_tokens')
            ->where('token', $request->input('auth.token'))
            ->get();

        return !$user->isEmpty();
    }
}
