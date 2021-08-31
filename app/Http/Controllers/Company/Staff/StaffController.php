<?php

namespace App\Http\Controllers\Company\Staff;

use App\Http\Controllers\Controller;
use App\Models\Company\Staff\UsersModel;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('data.username');
        $password = md5($request->input('data.password'));

        $staff = UsersModel::query()
            ->where('UserName', $username)
            ->where('Userpass', $password)
            ->first();

        if(!$staff){
            return response()->json([
                'message' => 'Invalid username/password',
            ], 404);
        }

        return response()->json([
         'staff' => $staff
        ], 200);
    }
}
