<?php
namespace App\Utilities;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

    function connectToDatabase($databaseConnection = []){
        $dbHost = $databaseConnection['dbHost'];
        $dbPort = $databaseConnection['dbPort'];
        $dbUsername = $databaseConnection['dbUsername'];
        $dbPassword = $databaseConnection['dbPassword'];
        $dbName = $databaseConnection['dbName'];

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

