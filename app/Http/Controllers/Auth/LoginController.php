<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\SendVerificationMail;
use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

       $userToken = Str::uuid();

        return response()->json([
            'id' => $user->getAttribute('MyIndex'),
            'username' => $user->getAttribute('UserName'),
            'full_name' => $user->getAttribute('RealName'),
            'user_token' => $userToken
        ]);
    }

    public function requestToken(Request $request)
    {
        $this->validate($request,[
           'data.contact' => ['required'],
            'data.device_uuid'=>['required']
        ]);

        $verificationToken = Str::random(6);
        $expiryTime = (new Carbon())->addHours(2)->toDateTimeString();

        Mail::to($request->input('data.contact'))
            ->send(new SendVerificationMail('perezcatoc@gmail.com',
                $verificationToken));

        DB::connection('company_database')
            ->table('appdevices')->where('DeviceUUID',
                $request->input('data.device_uuid'))->insert([
                'DeviceToken' => $verificationToken,
                'DeviceTokenExpiry' => $expiryTime,
                'DeviceStatus' => 'unverified'
            ]);

        return response()->json([
            'message' => 'token sent'
        ]);
    }

    public function verifyToken(Request $request)
    {
        $this->validate($request, [
           'data.verification_token' => ['required']
        ]);

        $token = DB::connection('company_database')
            ->table('appdevices')->where('DeviceToken',
                $request->input('data.verification_token'))->get();

        if($token->isEmpty()){
            return response()->json([
                'message' => 'Invalid token'
            ], Response::HTTP_NOT_FOUND);
        }


        DB::connection('company_database')
            ->table('appdevices')->where('DeviceToken',
                $request->input('data.verification_token'))
            ->update([
                'DeviceStatus' => 'verified',
                'DeviceTokenExpiry' => null
            ]);

        return response()->json([
            'message' => 'device verified'
        ], Response::HTTP_OK);
    }

    public function registerDevice(Request $request)
    {
        $this->validate($request,[
           'data.deviceUUID' => ['required']
        ]);

        DB::connection('company_database')
            ->table('appdevices')->insert([
                'DeviceUUID' => $request->input('data.deviceUUID')
            ]);

        return response()->json([
            'message' => 'device registered'
        ], Response::HTTP_OK);
    }
}
