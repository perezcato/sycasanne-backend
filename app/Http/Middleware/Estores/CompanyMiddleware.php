<?php

namespace App\Http\Middleware\Estores;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyMiddleware
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
        if(!$this->checkCompany($request)){
            return response()
                ->json(
                    ['message' => 'Company does not exists'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
        return $next($request);
    }

    private function checkCompany(Request $request):bool
    {
        $code = $request->method() === 'POST' ?
            $request->input('company.code') :
            $request->get('company_code');

        return $code?true:false;
    }
}
