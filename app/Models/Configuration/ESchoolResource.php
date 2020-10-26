<?php

namespace App\Models\Configuration;

use App\Http\Requests\Configuration\ESchoolResourceRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ESchoolResource extends Model
{
    use HasFactory;

    protected $table = 'ConfigDb';
    protected $connection = 'setting_database';
    public $timestamps = false;


    public static function findCompany(ESchoolResourceRequest $request)
    {
       $school = ESchoolResource::where('TheCode',$request->input('code'))
           ->select('MyIndex', 'TheCode', 'CompanyName',
               'CompanyLogo', 'LogoURL', 'dbHost',
               'dbName', 'dbPort', 'dbUsername',
               'dbPassword')->first();

       return $school;
    }
}
