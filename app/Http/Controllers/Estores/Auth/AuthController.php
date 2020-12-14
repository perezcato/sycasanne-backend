<?php

namespace App\Http\Controllers\Estores\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterDeviceRequest;
use App\Http\Requests\Estores\SiginRequest;
use App\Models\Configuration\ESchoolResource;
use App\Models\Estores\Auth;
use App\Models\Estores\Users\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function signIn(SiginRequest $request)
    {
        $user = Users::getUser($request);
        if(!$user){
            return response()
                ->json(
                    ['message' => 'Invalid username or password'],
                    Response::HTTP_UNAUTHORIZED
                );
        }

        $token = Auth::signIn($request->input('company.code'),$user->UserName);

        return response()->json([
            'username' => $user->UserName,
            'email' => $user->Email,
            'token' => $token
        ]);
    }
}
