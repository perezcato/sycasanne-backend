<?php

namespace App\Http\Controllers\Estores\Products;

use App\Http\Controllers\Controller;
use App\Models\Estores\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    public function searchProduct(Request $request)
    {
        $products = Product::getProduct($request);
        return response()->json($products);
    }

    public function update(Request $request, $id)
    {
        Product::updateProduct($request, $id);
        return response()->json([],Response::HTTP_OK);
    }
}
