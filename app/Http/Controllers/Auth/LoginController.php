<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterDeviceRequest;
use App\Http\Requests\Auth\TokenRequest;
use App\Http\Requests\Auth\VerifyTokenRequest;
use App\Http\Resources\UserResource;
use App\Libraries\SMS;
use App\Models\Auth\Device;
use App\Models\Auth\Staff;
use App\Models\Auth\User;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::validateUserFromRequest($request);

       if(!$user){
           return response()->json([
               'message' => 'Invalid username/password'
           ], Response::HTTP_NOT_FOUND);
       }

       $userToken = $user->createToken($user->getAttribute('UserName'))
           ->plainTextToken;

        return (new UserResource($user))->response();
    }

    public function requestToken(TokenRequest $request, SMS $sms):JsonResponse
    {
        $staff = Staff::where('TelMobile',$request->input('data.contact'))->first();
        if($staff){
            $token = Device::generateToken(
                $request->input('data.deviceUUID'),
                $request->input('data.contact')
            );

            ['smsUSERNAME' => $username,'smsPASSWORD' => $password,'smsSENDERID' => $senderId] =
                (ESchoolResource::select('smsUSERNAME','smsPASSWORD','smsSENDERID')
                    ->where('dbHost',$request->input('database.host'))
                    ->where('dbPort',$request->input('database.port'))
                    ->where('dbName', $request->input('database.name'))
                    ->where('dbUsername', $request->input('database.username'))
                    ->where('dbPassword', $request->input('database.password'))
                    ->first())->toArray();

            $sms->setUp([
                'user' => $username,
                'password' => $password,
                'type' => 'longSMS',
                'gsm' => $request->input('data.contact'),
                'text' => "Your activation code is {$token}",
                'sender' => $senderId
            ])->send();

            return response()->json(['message' => 'Activation code sent']);
        }
        return response()->json(['message'=>'Invalid Number provided'],Response::HTTP_NOT_FOUND);
    }

    public function registerDevice(RegisterDeviceRequest $request):JsonResponse
    {
        $device = Device::register($request->input('data.deviceUUID'));

        return response()->json(['device_id'=>$device->DevIndex], Response::HTTP_OK);
    }

    public function verifyToken(VerifyTokenRequest $request):JsonResponse
    {
        $verify = Device::verifyToken($request->input('data.verification_token'));

        return $verify ? response()->json(['message' => 'Device Verified'],Response::HTTP_OK) :
            response()->json(['message' => 'Invalid Code'],Response::HTTP_NOT_FOUND);
    }

}
