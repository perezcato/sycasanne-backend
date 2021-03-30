<?php

namespace App\Models\Estores;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Auth extends Model
{
    use HasFactory;
    protected $table = 'EstoresAuth';
    protected $connection = 'setting_database';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['token', 'loginTime', 'companyCode', 'user'];

    protected $casts = [
      'loginTime' => 'datetime'
    ];

    public static function signIn($companyCode, $username)
    {
        $token = Str::random(42);
        self::create([
           'token' => $token,
           'loginTime' => Carbon::now(),
            'companyCode' => $companyCode,
            'user' => $username
        ]);

        return $token;
    }

    public static function signOut(Request $request)
    {
        $authCode = $request->header('authorization');
        $token = self::where('token','=',$authCode)->first();
        $token->delete();
        return true;
    }
}
