<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();

        ProductVariant::query()->truncate();
        DB::table('product_tag')->truncate();
        ProductGallery::query()->truncate();
        Product::query()->truncate();
        ProductSize::query()->truncate();
        ProductColor::query()->truncate();
        Tag::query()->truncate();

        Tag::factory(15)->create();

        foreach (['S', 'X', 'XL', 'XXL'] as $item) {
            ProductSize::query()->create(
                ['name' => $item]
            );
        }

        foreach (['#FF0000', '#00FFFF', '#FFCCFF', '#FF9900'] as $item) {
            ProductColor::query()->create(
                ['name' => $item]
            );
        }

        for ($i = 0; $i < 1000; $i++) {
            $name = fake()->text(100);
            Product::query()->create([
                'catalogue_id' => rand(26, 29),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(8),
                'sku' => Str::random(7) . $i,
                'img_thumbnail' => 'https://canifa.com/img/1000/1500/resize/8/b/8bs24s022-sa321-xl-1-u.webp',
                'price_regular' => 300000,
                'price_sale' => 280000,
            ]);
        }

        for ($i = 1; $i < 1001; $i++) {
            ProductGallery::query()->insert([
                [
                    'product_id' => $i,
                    'image' => 'https://canifa.com/img/1000/1500/resize/8/b/8bs24s022-sa321-xl-1-u.webp',
                ],
                [
                    'product_id' => $i,
                    'image' => 'https://canifa.com/img/1000/1500/resize/8/b/8bs24s022-sa321-xl-1-u.webp',
                ],
            ]);

        }

        for ($i = 1; $i < 1001; $i++) {
            DB::table('product_tag')->insert([
                [
                    'product_id' => $i,
                    'tag_id' => rand(1, 8)
                ],
                [
                    'product_id' => $i,
                    'tag_id' => rand(9, 15)
                ],
            ]);
        }

        for ($productId = 1; $productId < 1001; $productId++) {
            $data = [];
            for ($sizeId = 1; $sizeId < 5; $sizeId++) {
                for ($colorId = 1; $colorId < 5; $colorId++) {
                    $data = [
                        'product_id' => $productId,
                        'product_size_id' => $sizeId,
                        'product_color_id' => $colorId,
                        'quantity' => rand(10, 50),
                        'image' => 'https://canifa.com/img/1000/1500/resize/8/b/8bs24s022-sa321-xl-1-u.webp'
                    ];
                }
            }
            DB::table('product_variants')->insert($data);
        }

    }
}
