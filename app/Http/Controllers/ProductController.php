<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($slug)
    {
        $product = Product::query()->with('variants.color', 'galleries')->where('slug', $slug)->first();
        // dd($product);
        return view('product_detail', compact('product'));
    }
}
