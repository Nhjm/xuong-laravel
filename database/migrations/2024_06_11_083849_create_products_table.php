<?php

use App\Models\Catalogue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Catalogue::class)->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->comment('mã sản phẩm');
            $table->string('img_thumbnail')->nullable();
            $table->double('price_regular')->comment('giá bán thường');
            $table->double('price_sale')->nullable()->comment('giá bán sale');
            $table->string('description')->nullable()->comment('mô tả');
            $table->text('content')->nullable()->comment('nội dung');
            $table->string('material')->nullable()->comment('chất liệu');
            $table->text('user_manual')->nullable()->comment('hướng dẫn sd');
            $table->boolean('is_active')->default(true)->comment('trạng thái hiển thị');
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_good_deal')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_show_home')->default(false);
            $table->unsignedBigInteger('view')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
