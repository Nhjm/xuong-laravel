<?php

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(ProductVariant::class)->constrained();
            $table->unsignedInteger('quantity')->default(1);
            //sao lưu thông tin sản phẩm
            $table->string('name');
            $table->string('sku')->comment('mã sản phẩm');
            $table->string('img_thumbnail')->nullable();
            $table->double('price_regular')->comment('giá bán thường');
            $table->double('price_sale')->nullable()->comment('giá bán sale');
            //sao lưu thông tin biến thể
            $table->string('variant_size_name');
            $table->string('variant_color_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
