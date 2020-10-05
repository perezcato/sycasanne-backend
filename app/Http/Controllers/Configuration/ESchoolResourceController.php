<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Configuration\ESchoolResourceRequest;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Http\Request;

class ESchoolResourceController extends Controller
{
    public function index(ESchoolResourceRequest $request)
    {
        $school = ESchoolResource::where('TheCode',$request->input('code'))
            ->select('MyIndex','CompanyLogo','CompanyName','LogoURL')
            ->get();

        return response()->json([
            'data' => $school
        ]);
    }
}
