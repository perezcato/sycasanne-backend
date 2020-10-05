<?php

use Illuminate\Http\Request;

if(!function_exists('connectToDatabaseFromRequest')){
    function connectToDatabaseFromRequest(Request $request){
        $dbHost = $request->header('dbHost');
        $dbPort = $request->header('dbPort');
        $dbUsername = $request->header('dbUsername');
        $dbPassword = $request->header('dbPassword');
        $dbName = $request->header('dbName');

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
