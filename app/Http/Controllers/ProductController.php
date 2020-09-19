<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only('name', 'price'));
        return $product;
    }

    public function show($id)
    {
        $product = Product::find($id);
        return $product;
    }

    public function update(Request $request, $id)
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