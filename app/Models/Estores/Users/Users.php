<?php

namespace App\Models\Estores\Users;

use App\Http\Requests\Estores\Auth\AddUserRequest;
use App\Http\Requests\Estores\SiginRequest;
use App\Models\Configuration\ESchoolResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Users extends Model
{
    use HasFactory;

    public static function getUser(SiginRequest $request)
    {
        $company = ESchoolResource::userTableName($request->input('company.code'));
        return DB::connection('setting_database')->table(Str::upper($company))
            ->where('UserName', $request->input('user.username'))
            ->where('UserPass', $request->input('user.password'))
            ->first();
    }

    public static function addUser(AddUserRequest $request)
    {
        $company = ESchoolResource::userTableName($request->input('company.code'));
        return DB::connection('setting_database')->table(Str::upper($company))->insert([
            'UserName' => $request->input('user.username'),
            'UserPass' => $request->input('user.password'),
            'Email' => $request->input('user.email'),
            'ChangePrc' => $request->input('user.change_price'),
            'ViewSales' => $request->input('user.view_sales'),
            'CheckBalance' => $request->input('user.check_balance'),
            'AddUsers' => $request->input('user.add_users'),
        ]);
    }
}
