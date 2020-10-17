<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterDeviceRequest;
use App\Http\Requests\Auth\TokenRequest;
use App\Http\Requests\Auth\VerifyTokenRequest;
use App\Mail\ActivationToken;
use App\Models\Auth\Device;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

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

       $userToken = $user->createToken($user->getAttribute('UserName'))
           ->plainTextToken;

        return response()->json([
            'id' => $user->getAttribute('MyIndex'),
            'username' => $user->getAttribute('UserName'),
            'full_name' => $user->getAttribute('RealName'),
            'user_token' => $userToken
        ]);
    }

    public function requestToken(TokenRequest $request):JsonResponse
    {
        $token = Device::generateToken($request->input('data.deviceUUID'));
        Mail::to($request->input('data.contact'))->send(new ActivationToken($token));

        return response()->json(['message' => 'Activation code sent']);
    }

    public function registerDevice(RegisterDeviceRequest $request):JsonResponse
    {
        Device::register($request->input('data.deviceUUID'));

        return response()->json(['message'=>'Device Registered'], Response::HTTP_OK);
    }

    public function verifyToken(VerifyTokenRequest $request):JsonResponse
    {
        $verify = Device::verifyToken($request->input('data.verification_token'));

        return $verify ? response()->json(['message' => 'Device Verified'],Response::HTTP_OK) :
            response()->json(['message' => 'Device Unverified'],Response::HTTP_NOT_FOUND);
    }




}
