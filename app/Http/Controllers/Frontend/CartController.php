<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //
    public function add(Request $request)
    {
        //dd($request);
        $product = Product::findOrFail($request->input('product_id'));
        Cart::add(
            $product->id,
            $product->name,
            $request->input('quantity'),
            $product->price
        );
        return redirect()->route('frontend.cart.add');
    }
}