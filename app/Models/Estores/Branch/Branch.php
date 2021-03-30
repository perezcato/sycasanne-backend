<?php

namespace App\Models\Estores\Branch;

use App\Models\Configuration\ESchoolResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    use HasFactory;

    public static function getBranches(Request $request)
    {
        $company = $request->get('company_code');
        return DB::connection('setting_database')
            ->table(ESchoolResource::branchName($company))
            ->select('BranchName')
            ->get();
    }

    public static function getBranchesNumber(Request $request)
    {
        $company = $request->get('company_code');
        return DB::connection('setting_database')
            ->table(ESchoolResource::branchName($company))
            ->select()
            ->count();
    }

    public static function getBranchesLastUpdate(Request $request)
    {
        $company = $request->get('company_code');

        return DB::connection('setting_database')
            ->table(ESchoolResource::branchName($company))
            ->select('BranchName','updated_at')
            ->get();
    }
}
