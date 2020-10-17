<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuration\ESchoolResourceRequest;
use App\Http\Resources\Config\ConfigResource;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ESchoolResourceController extends Controller
{
    public function index(ESchoolResourceRequest $request)
    {
        $school = ESchoolResource::where('TheCode',$request->input('code'))
            ->select('MyIndex', 'TheCode', 'CompanyName',
                'CompanyLogo', 'LogoURL', 'dbHost',
                'dbName', 'dbPort', 'dbUsername',
                'dbPassword')->first();

        $deviceUUID = Str::uuid();

        return $school ? (new ConfigResource($school))->response() :
            response()->json([
                'message' => 'company not found'
            ],
                Response::HTTP_NOT_FOUND);
    }
}
