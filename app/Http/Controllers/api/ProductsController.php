<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductsController extends ApiController
{

    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    public function store(Request $request)
    {

        $product = Product::Where('code', $request->code)->first();

        if($product) return $this->errorResponse("Ya existe un producto con ese código", 400);

        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'stock' => 'required',
            'precio' => 'required',
            'description' => 'required',
            'provider_id' => 'required',
        ]);

        $product = new Product($request->except('photo'));

        if ($request->hasFile('photo')) {
            $product->photo = $request->file('photo')->store("products", 'public');
        }
        $product->save();

        return $this->showOne($product);
    }

    public function show(Product $product)
    {
        return $this->showOne($product->load('provider:id,name'));
    }

    public function update(Request $request, Product $product)
    {
        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($product->photo);
            $product->photo = $request->file('photo')->store('products', 'public');
        }

        $product->update($request->except('photo'));


        return $this->showOne($product);
    }


    public function destroy(Product $product)
    {

        if(!$product) return $this->errorResponse("El producto no existe", 400);

        $product->delete();

        return $this->showOne($product);
    }
}
