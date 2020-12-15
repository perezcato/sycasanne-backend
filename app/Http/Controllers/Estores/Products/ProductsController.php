<?php

namespace App\Http\Controllers\Estores\Products;

use App\Http\Controllers\Controller;
use App\Models\Estores\Products\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function searchProduct(Request $request)
    {
        $products = Product::getProduct($request);
        return response()->json([$products]);
    }
}
