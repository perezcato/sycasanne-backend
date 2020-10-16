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

