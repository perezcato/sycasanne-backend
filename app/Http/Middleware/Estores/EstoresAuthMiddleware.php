<?php

namespace App\Http\Middleware\Estores;

use App\Models\Estores\Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EstoresAuthMiddleware
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
        if(!$this->checkHeader($request)){
            return response()->json(['message' => 'user locked'],Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    public function checkHeader(Request $request):bool
    {
        if($request->hasHeader('authorization')){
            $authorization = $request->header('authorization');
            if($authorization){
                $token = Auth::where('token','=',trim($authorization))->first();
                if($token){
                    $user = DB::where('UserName','=',$token->user)->first();
                    if($user && ($user->LoginStatus == '0')){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
