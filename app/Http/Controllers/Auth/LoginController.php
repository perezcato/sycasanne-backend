<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
           'data.username' => ['required'],
            'data.password' => ['required']
        ]);

        $password = md5($request->input('data.password'));
        $user = User::where('UserName', $request->input('data.username'))
            ->where('Userpass',$password)
            ->first();

       if(!$user){
           throw ValidationException::withMessages([
              'auth' => 'invalid username/password'
           ]);
       }

       $userToken = Str::uuid()->toString();

        return response()->json([
            'id' => $user->getAttribute('MyIndex'),
            'username' => $user->getAttribute('UserName'),
            'full_name' => $user->getAttribute('RealName'),
            'user_token' => $userToken
        ]);
    }
}
