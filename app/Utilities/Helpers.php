<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if(!function_exists('connectToDatabaseFromRequest')){
    function connectToDatabaseFromRequest(Request $request){
        $dbHost = $request->input('database.host');
        $dbPort = $request->input('database.port');
        $dbUsername = $request->input('database.username');
        $dbPassword = $request->input('database.password');
        $dbName = $request->header('database.name');

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
