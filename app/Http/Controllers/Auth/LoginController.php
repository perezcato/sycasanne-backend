<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $password = md5($request->input('data.password'));
//        $user = User::where('UserName', $request->input('data.username'))
//            ->where('Userpass',$password)
//            ->get();

        $user = DB::select('show tables');




        return response()->json($user);
    }
}
