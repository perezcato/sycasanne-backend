<?php

namespace App\Http\Middleware\Configuration;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        if(!$this->connectToDatabaseFromRequest($request)){
            return response()->json([
                'error' => 'Invalid database credentials'
            ], Response::HTTP_BAD_REQUEST);
        }
        return $next($request);
    }

    private function connectToDatabaseFromRequest(Request $request)
    {
        $dbHost = $request->input('database.host');
        $dbPort = $request->input('database.port');
        $dbUsername = $request->input('database.username');
        $dbPassword = $request->input('database.password');
        $dbName = $request->input('database.name');

        if($dbHost && $dbPort && $dbUsername && $dbPassword && $dbName){
            config([
                'database.connections.company_database.host' => $dbHost,
                'database.connections.company_database.port' => $dbPort,
                'database.connections.company_database.database' => $dbName,
                'database.connections.company_database.username' => $dbUsername,
                'database.connections.company_database.password' => $dbPassword,
            ]);
            DB::purge('company_database');
            DB::reconnect('company_database');
            Schema::connection('company_database')->getConnection()->reconnect();
            return true;
        }
        return false;
    }
}
