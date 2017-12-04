<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'quantity'  => 'required',
            'price'  => 'required',
        ]);

        $product = Product::create([
            'name'     => request('name'),
            'quantity' => request('quantity'),
            'price'    => request('price')
        ]);

        return response()->json([
            'product'    => $product,
            'message' => 'Success'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'quantity'  => 'required',
            'price'  => 'required',
        ]);
 
        $product->name = request('name');
        $product->quantity = request('quantity');
        $product->price = request('price');
        $product->save();
 
        return response()->json([
            'message' => 'Product updated successfully!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Not able to delete product!'
            ], 409);
        }

        return response()->json([
            'message' => 'Product deleted successfully!'
        ], 200);
    }

    /**
     * Show the products index page
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPage()
    {
        return view('pages.products');
    }
}
