<?php

use Illuminate\Http\Request;

if(!function_exists('connectToDatabaseFromRequest')){
    function connectToDatabaseFromRequest(Request $request){
        $dbHost = $request->input('database.host');
        $dbPort = $request->input('database.port');
        $dbUsername = $request->input('database.username');
        $dbPassword = $request->input('database.password');
        $dbName = $request->header('database.name');

        if($dbHost && $dbPort && $dbUsername && $dbPassword && $dbName){
            config([
                'database.company_database.host' => $dbHost,
                'database.company_database.port' => $dbPort,
                'database.company_database.database' => $dbName,
                'database.company_database.username' => $dbUsername,
                'database.company_database.password' => $dbPassword,
            ]);
            return true;
        }
        return false;
    }
}
