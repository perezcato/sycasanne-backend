<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuration\ESchoolResourceRequest;
use App\Http\Resources\Config\ConfigResource;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use function App\Utilities\connectToDatabase;

class ESchoolResourceController extends Controller
{
    public function index(ESchoolResourceRequest $request)
    {
        $school = ESchoolResource::where('TheCode',$request->input('code'))
            ->select('MyIndex', 'TheCode', 'CompanyName',
                'CompanyLogo', 'LogoURL', 'dbHost',
                'dbName', 'dbPort', 'dbUsername',
                'dbPassword')->first();

        if(!$school){
            return  response()->json([
                'message' => 'company not found'
            ],
                Response::HTTP_NOT_FOUND);
        }
        $deviceUUID = Str::uuid();

        return (new ConfigResource($school, $deviceUUID))->response();
    }

    private function connectToDatabase($databaseConnection = []){

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

}
