<?php

use App\Models\User;
use App\Models\Image;
use App\Models\Article;
use App\Models\Product;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckAdminMiddleware;

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
    // return view('welcome', compact('products'));

    // Article::findOrFail(1)->comments()->create([
    //     'user_id' => 20,
    //     'content' => 'comment article 1'
    // ]);

    // Image::findOrFail(1)->comments()->create([
    //     'user_id' => 20,
    //     'content' => 'comment image 1'
    // ]);

    // Article::findOrFail(2)->ratings()->create([
    //     'user_id' => 20,
    //     'rating' => 8
    // ]);

    $comments = User::findOrFail(20)->comments;

    $comment_articles = $comments->filter(function ($comment) {
        return $comment->commentable_type == Article::class;
    });

    $comment_images = $comments->filter(function ($comment) {
        return $comment->commentable_type == Image::class;
    });

    $comment_videos = $comments->filter(function ($comment) {
        return $comment->commentable_type == Video::class;
    });

    // $top_rating_article = Article::with([
    //     'ratings' => function ($query) {
    //         $query->select(DB::raw('ratingable_id, avg(rating) as avg_rating'))
    //             ->groupBy('ratingable_id')
    //             ->orderBy('avg_rating', 'desc')
    //             ->take(5);
    //     }
    // ])->get();

    $top_rating_article = Article::withAvg('ratings', 'rating')
        ->orderByDesc('ratings_avg_rating')
        ->having('ratings_avg_rating', '>', 0)
        ->take(5)
        ->get();

    $top_rating_image = Image::withAvg('ratings', 'rating')
        ->orderByDesc('ratings_avg_rating')
        ->having('ratings_avg_rating', '>', 0)
        ->take(5)
        ->get();

    $top_rating_video = Video::withAvg('ratings', 'rating')
        ->orderByDesc('ratings_avg_rating')
        ->having('ratings_avg_rating', '>', 0)
        ->take(5)
        ->get();

    // dd(
    //     Article::findOrFail(1)->comments,
    //     Video::findOrFail(1)->ratings,
    //     User::findOrFail(20)->comments,
    //     Article::findOrFail(1)->ratings()->avg('rating'),
    //     $comment_user = [
    //         $comment_articles,
    //         $comment_images,
    //         $comment_videos,
    //     ],
    //     $top_rating = [
    //         $top_rating_article,
    //         $top_rating_image,
    //         $top_rating_video
    //     ]
    // );

    return 1;
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

