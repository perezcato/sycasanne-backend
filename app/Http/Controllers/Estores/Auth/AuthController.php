<?php

namespace App\Http\Controllers\Estores\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterDeviceRequest;
use App\Http\Requests\Estores\Auth\AddUserRequest;
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
        if($user->LoginStatus == '0'){
            return response()
                ->json(
                    ['message' => 'User Locked'],
                    Response::HTTP_UNAUTHORIZED
                );
        }
        $token = Auth::signIn($request->input('company.code'),$user->UserName);
        return response()->json([
            'username' => $user->UserName,
            'email' => $user->Email,
            'token' => $token,
            'change_price' => $user->ChangePrc,
            'view_sales' => $user->ViewSales,
            'check_balance' => $user->CheckBalance,
            'add_users' => $user->AddUsers,
        ]);
    }

    public function addUser(AddUserRequest $request)
    {
        Users::addUser($request);
        return response()->json(['message' => 'user added']);
    }
    public function signOut(Request $request)
    {
        Auth::signOut($request);
        return response()->json(['message' => 'user signed out']);
    }
}
