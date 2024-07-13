<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckAdminMiddleware;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $products = Product::query()->latest('id')->limit(4)->get();
    return view('welcome', compact('products'));
})->name('index');

Route::get('product/{slug}', [ProductController::class, 'index'])->name('product');

Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');

Route::get('cart/index', [CartController::class, 'index'])->name('cart.index');

Route::post('order/add', [OrderController::class, 'add'])->name('order.add');


// Route::get('admin', function () {
//     return 'admin';
// })->middleware(CheckAdminMiddleware::class);

// Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

