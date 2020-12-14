<?php

namespace App\Models\Configuration;

use App\Http\Requests\Configuration\ESchoolResourceRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ESchoolResource extends Model
{
    use HasFactory;

    protected $table = 'ConfigDb';
    protected $connection = 'setting_database';
    public $timestamps = false;


    public static function findCompany(ESchoolResourceRequest $request)
    {
       $school = ESchoolResource::where('TheCode',$request->input('code'))
           ->select()->first();

       return $school;
    }

    public static function getEstores()
    {
        return self::where('COMPTYPE','ESTORES')->get();
    }

    public static function branchName($code)
    {
        return str_replace(" ","",Str::upper($code.'branches'));
    }

    public static function productsName($code)
    {
        return str_replace(" ","",Str::upper($code.'products'));
    }

    public static function userTableName($code)
    {
        return str_replace(" ","",Str::upper($code.'users'));
    }
    public static function deviceName($code)
    {
        return str_replace(" ","",Str::upper($code.'devices'));
    }
}
