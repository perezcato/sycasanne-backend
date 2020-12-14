<?php

namespace App\Models\Estores\Products;

use App\Models\Configuration\ESchoolResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    public static function getProduct(Request $request)
    {
        $searchTerm = $request->get('s_term');
        return DB::connection('setting_database')
            ->table(ESchoolResource::productsName($request->get('company_code')))
            ->where('ItemName','LIKE', "%{$searchTerm}%")
            ->select()
            ->get();
    }
}
