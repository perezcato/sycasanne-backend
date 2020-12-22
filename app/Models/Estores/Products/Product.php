<?php

namespace App\Models\Estores\Products;

use App\Http\Requests\Estores\Products\ProductHistoryRequest;
use App\Http\Requests\Estores\Products\ProductRequest;
use App\Models\Configuration\ESchoolResource;
use Database\Factories\ProductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $table = 'VENUSPRODUCTS';
    protected $connection = 'setting_database';

    public $timestamps = false;


    public static function getProduct(Request $request)
    {
        $searchTerm = $request->get('s_term');
        return DB::connection('setting_database')
            ->table(ESchoolResource::productsName($request->get('company_code')))
            ->where('ItemName','LIKE', "%{$searchTerm}%")
            ->select()
            ->simplePaginate(16);
    }

    public static function getProductNumber(Request $request)
    {
        return DB::connection('setting_database')
            ->table(ESchoolResource::productsName($request->get('company_code')))
            ->select()
            ->count();
    }

    public static function updateProduct(Request $request,$id)
    {
        return DB::connection('setting_database')
            ->table(ESchoolResource::productsName($request->input('company.code')))
            ->where('ProductsID','=',$id)
            ->update($request->except(['company','ProductsID']));
    }

    public static function addProduct(ProductRequest $request)
    {
        return DB::connection('setting_database')
            ->table(ESchoolResource::productsName($request->input('company.code')))
            ->insert([
                'ItemName' => $request->input('products.item_name'),
                'UniversalID' => Str::uuid(),
                'SP' => $request->input('products.sp'),
                'CP' => $request->input('products.cp'),
                'NP' => 1,
            ]);
    }

    public static function requestProductHistory(ProductHistoryRequest $request)
    {
        return DB::connection('setting_database')
            ->table('ViewSales')
            ->insert($request->except('company'));
    }
}
