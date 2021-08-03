<?php

namespace App\Models\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $connection = 'mysql';
    protected $table = 'users';
    protected $primaryKey = 'MyIndex';
    public $timestamps = false;

    protected $accessToken;


    public static function validateUserFromRequest(LoginRequest $request)
    {
        $password = md5($request->input('data.password'));
        return User::where('UserName', $request->input('data.username'))
            ->where('Userpass',$password)
            ->first();
    }

    public static function getUsers ()
    {
        return User::select('MyIndex','UserName','Userpass')->get();
    }


}
