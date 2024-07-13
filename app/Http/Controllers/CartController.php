<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add()
    {

        $product = Product::query()->findOrFail(request('product_id'));
        $variant = ProductVariant::query()->with(['color', 'size'])
            ->where('product_id', request('product_id'))
            ->where('product_size_id', request('product_size_id'))
            ->where('product_color_id', request('product_color_id'))
            ->firstOrFail();

        // session()->flush(); 
        $cart = session('cart', []);

        // dd(session()->all());

        if (!isset($cart[$variant->id])) {
            $data = $product->toArray() + $variant->toArray() + ['product_quantity' => request('quantity')];
            $cart[$variant->id] = $data;
        } else {
            $cart[$variant->id]['product_quantity'] += request('quantity');
            // echo $cart[$variant->id]['product_quantity'];
        }

        session()->put('cart', $cart);



        return redirect()->route('cart.index')->with('success', 'thao tác thành công');
    }

    public function index()
    {
        $cart = session('cart', []);

        // dd($cart);

        $total_price = 0;

        foreach ($cart as $item) {
            $total_price += $item['product_quantity'] * ($item['price_sale'] ?: $item['price_regular']);
        }

        session()->put('cart_total_price', $total_price);

        return view('cart', compact('total_price'));
    }
}
