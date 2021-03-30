<?php

namespace App\Http\Controllers\Estores\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estores\Products\ProductHistoryRequest;
use App\Http\Requests\Estores\Products\ProductRequest;
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

    public function store(ProductRequest $request)
    {
        Product::addProduct($request);
        return response()->json([],Response::HTTP_CREATED);
    }

    public function requestHistory(ProductHistoryRequest $request)
    {
        Product::requestProductHistory($request);
        return response()->json(['message' => 'request successful'],Response::HTTP_CREATED);
    }
}
