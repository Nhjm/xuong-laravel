<?php

use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            //xác định người dùng trên hệ thống
            $table->foreignIdFor(User::class)->constrained();
            //thông tin nhận hàng
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_address');
            $table->string('user_notes')->nullable();
            $table->timestamps();

            $table->string('status_order')->default(Order::STATUS_ORDER_PENDING);
            $table->string('status_payment')->default(Order::STATUS_PAYMENT_UNPAID);

            $table->double('total_price', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
