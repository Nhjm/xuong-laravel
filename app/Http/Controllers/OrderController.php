<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function add()
    {
        // dd(request()->all(), session()->all());

        try {

            DB::transaction(function () {
                $user = User::where('email', request('user_email'))->first();

                if (!$user) {
                    $user = User::query()->create([
                        'name' => request('user_name'),
                        'email' => request('user_email'),
                        'password' => bcrypt(request('name')),
                        'is_active' => false,
                    ]);
                }

                $order = Order::query()->create([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_phone' => request('user_phone'),
                    'user_address' => request('user_address'),
                    'user_notes' => request('user_notes'),
                    'total_price' => session('cart_total_price'),
                ]);

                $data_item = [];

                foreach (session('cart') as $variant_id => $item) {
                    $data_item[] = [
                        'order_id' => $order->id,
                        'product_variant_id' => $variant_id,
                        'quantity' => $item['product_quantity'],
                        'name' => $item['name'],
                        'sku' => $item['sku'],
                        'img_thumbnail' => $item['img_thumbnail'],
                        'price_regular' => $item['price_regular'],
                        'price_sale' => $item['price_sale'],
                        'variant_size_name' => $item['size']['name'],
                        'variant_color_name' => $item['color']['name'],
                    ];
                }
                // dd($data_item);

                foreach ($data_item as $item) {
                    // dd($item);
                    OrderItem::query()->create($item);
                }

                event(new OrderCreated($order));

            });

            session()->forget(['cart', 'cart_total_price']);

            return redirect()->route('index')->with('success', 'đặt hàng thành công');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'lỗi đặt hàng');
        }
    }
}
