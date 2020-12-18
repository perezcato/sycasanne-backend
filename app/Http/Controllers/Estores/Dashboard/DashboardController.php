<?php

namespace App\Http\Controllers\Estores\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Configuration\ESchoolResource;
use App\Models\Estores\Branch\Branch;
use App\Models\Estores\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $branches = (DB::connection('setting_database')
            ->table(ESchoolResource::branchName($request->get('company_code')))
            ->select()
            ->get())->toArray();

        $dailySales = array_reduce($branches, function ($sales, $branchSale){
            $sales += $branchSale['DailySALES'];
            return $sales;
        });

        $monthlySales = array_reduce($branches, function ($sales, $branchSale){
            $sales += $branchSale['MonthlySALES'];
            return $sales;
        });

        $products = Product::getProductNumber($request);
        $branchesSize = Branch::getBranchesNumber($request);

        return response()->json([
           'products' => $products,
           'branches' => $branchesSize,
           'daily' => $dailySales,
           'monthly' => $monthlySales
        ]);
    }
}
