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
        $school = ESchoolResource::findCompany($request);

        return $school ? (new ConfigResource($school, Str::uuid()))->response() :
            response()->json([
                'message' => 'company not found'
            ],
                Response::HTTP_NOT_FOUND);
    }
}
