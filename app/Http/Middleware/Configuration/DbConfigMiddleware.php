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
                'database.connections.mysql.host' => $dbHost,
                'database.connections.mysql.port' => $dbPort,
                'database.connections.mysql.database' => $dbName,
                'database.connections.mysql.username' => $dbUsername,
                'database.connections.mysql.password' => $dbPassword,
            ]);
            DB::purge('mysql');
            DB::reconnect('mysql');
            Schema::connection('mysql')->getConnection()->reconnect();
            return true;
        }
        return false;
    }
}
