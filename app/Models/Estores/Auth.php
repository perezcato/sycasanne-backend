<?php

namespace App\Models\Estores;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Auth extends Model
{
    use HasFactory;
    protected $table = 'EstoresAuth';
    protected $connection = 'setting_database';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['token', 'loginTime', 'companyCode', 'user'];



    public static function signIn($companyCode, $username)
    {
        $token = Str::random(42);
        $time = Carbon::now()->toString();
        self::create([
           'token' => $token,
           'loginTime' => $time,
            'companyCode' => $companyCode,
            'user' => $username
        ]);

        return $token;
    }
}
