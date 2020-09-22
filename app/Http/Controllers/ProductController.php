<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->only('name', 'price'));
        return $product;
    }

    public function show($id)
    {
        $product = Product::find($id);
        return $product;
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->only('name', 'price'));
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }
}