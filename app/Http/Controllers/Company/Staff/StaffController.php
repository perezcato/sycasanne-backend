<?php

namespace App\Http\Controllers\Company\Staff;

use App\Http\Controllers\Controller;
use App\Models\Company\Staff\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function searchClients (Request $request)
    {
        $clientName = $request->get('clientName');

        $clients = DB::table('newclients')
            ->where(function($query) use($clientName){
                $query->where('Surname','LIKE', "%{$clientName}%")
                    ->orWhere('Firstname','LIKE', "%{$clientName}%");
            })
            ->get();

        return response()->json([
            'clients' => $clients
        ]);
    }
}
