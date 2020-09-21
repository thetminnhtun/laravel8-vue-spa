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
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric'
        ], [
            'name.required' => 'အမည်ထည့်ရန်လိုအပ်သည်။',
            'name.string' => 'အမည်သည် စာသားဖြစ်ရမည်။',
            'price.required' => 'စေ◌ျးနိှုန်းထည့်ပါ။'
        ]);

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
        $request->validate([
            'name' => 'nullable|string',
            'price' => 'nullable|numeric'
        ], [
            'name.string' => 'အမည်သည် စာသားဖြစ်ရမည်။',
            'price.numeric' => 'စေ◌ျးနိှုန်း သည် ဂဏန်းဖြစ်ရမည်။'
        ]);


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