<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {

        $password = md5($request->input('data.password'));

        $user = User::where('UserName', $request->input('data.username'))
            ->where('Userpass',$password)
            ->first();

       if(!$user){
           return response()->json([
               'message' => 'Invalid username/password'
           ], Response::HTTP_NOT_FOUND);
       }

       $userToken = $user->createToken($user->UserName);

        return response()->json([
            'id' => $user->getAttribute('MyIndex'),
            'username' => $user->getAttribute('UserName'),
            'full_name' => $user->getAttribute('RealName'),
            'user_token' => $userToken
        ]);
    }
}
