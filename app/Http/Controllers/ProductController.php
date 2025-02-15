<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::query()->with(['variants.color', 'variants.size', 'galleries'])->where('slug', $slug)->first();
        // dd($product->variants);
        return view('product_detail', compact('product'));
    }
}
