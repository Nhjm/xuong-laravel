<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Catalogue;
use App\Models\ProductSize;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(session()->all());
        // print_r(session()->all());die;

        $data = Product::query()->with(['catalogue', 'tags'])->latest('id')->get();
        // dd($data->first());

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'))->with('success', '123123');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogues = Catalogue::query()->pluck('name', 'id');
        $colors = ProductColor::query()->pluck('name', 'id');
        $sizes = ProductSize::query()->pluck('name', 'id');
        $tags = Tag::query()->pluck('name', 'id');
        return view(self::PATH_VIEW . __FUNCTION__, compact('catalogues', 'colors', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        list(
            $dataProduct,
            $dataProductTags,
            $dataProductGalleries,
            $dataProductVariants,
            $all_image
        ) = $this->handleData($request);

        try {
            DB::beginTransaction();

            /** @var Product $product */

            $product = Product::query()->create($dataProduct);

            foreach ($dataProductVariants as $item) {
                $item += ['product_id' => $product->id];

                ProductVariant::query()->create($item);
            }

            foreach ($dataProductGalleries as $item) {
                $item += ['product_id' => $product->id];

                ProductGallery::query()->create($item);
            }

            $product->tags()->sync($dataProductTags);

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'thao tác thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            foreach ($all_image as $value) {
                if ($value && Storage::exists($value)) {
                    Storage::delete($value);
                }
            }
            dd($th->getMessage());
            return back()->with('error', 'thao tác thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $tags = Tag::query()->pluck('name', 'id');
        $colors = ProductColor::query()->pluck('name', 'id');
        $sizes = ProductSize::query()->pluck('name', 'id');
        $catalogues = Catalogue::query()->pluck('name', 'id');

        $product_variants = $product->variants()->with(['color', 'size'])->get();
        $product_sizes = $product_variants->pluck('size.name', 'size.id');
        $product_colors = $product_variants->pluck('color.name', 'color.id');
        $product_galleries = $product->galleries;
        $product_tags = $product->tags->pluck('id')->toArray();
        $product_catalogue = $product->catalogue;

        // dd($product, $product_tags, $product_variants, $product_sizes, $product_colors);
        return view(
            self::PATH_VIEW . __FUNCTION__,
            compact(
                'product',
                'product_variants',
                'product_galleries',
                'product_tags',
                'product_catalogue',
                'catalogues',
                'tags',
                'product_sizes',
                'product_colors',
                'tags',
                'colors',
                'sizes'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        // dd($product);

        list(
            $dataProduct,
            $dataProductTags,
            $dataProductGalleries,
            $dataProductVariants,
            $all_image
        ) = $this->handleData($request);

        // dd(
        //     $dataProduct,
        //     // $dataProductVariants,
        //     // $dataProductTags,
        //     // $dataProductGalleries,
        //     // $all_image
        // );

        try {
            DB::beginTransaction();

            $images_delete = [];

            $image_thumbnail_old = $product?->img_thumbnail;

            $product->update($dataProduct);

            if ($image_thumbnail_old && $request->img_thumbnail) {
                // dd($product->img_thumbnail, $request->img_thumbnail);
                $images_delete[] = $image_thumbnail_old;
            }

            $variant_image_olds = $product->variants()->pluck('image')->toArray();
            // dd($dataProductVariants);
            foreach ($dataProductVariants as $item) {

                $values = [
                    'quantity' => $item['quantity']
                ];

                if (!empty($item['image'])) {
                    $values['image'] = $item['image'];
                }

                $product->variants()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'product_size_id' => $item['product_size_id'],
                        'product_color_id' => $item['product_color_id'],
                    ],
                    $values
                );
            }

            foreach ($variant_image_olds as $value) {
                if (!in_array($value, $product->variants()->pluck('image')->toArray())) {
                    $images_delete[] = $value;
                }
            }
            // dd(
            //     $variant_image_olds,
            //     $variant_image_news,
            //     $images_delete
            // );

            if (!empty($dataProduct['product_galleries_old'])) {
                foreach ($product->galleries as $item) {
                    if (!in_array($item->image, $dataProduct['product_galleries_old'])) {
                        $images_delete[] = $product->galleries()->where('image', $item->image)->delete();
                    }
                }
            } else {
                $galleries = $product->galleries()->pluck('image')->toArray();
                foreach ($galleries as $value) {
                    $images_delete[] = $value;
                }
                $product->galleries()->delete();
            }
            foreach ($dataProductGalleries as $item) {
                $product->galleries()->create($item);
            }

            $product->tags()->sync($dataProductTags);

            DB::commit();

            foreach ($images_delete as $value) {
                if ($value && Storage::exists($value)) {
                    Storage::delete($value);
                }
            }

            session()->flash('success', 'thao tác thành công');

            // Trả về JSON response với URL để điều hướng
            return response()->json([
                'success' => true,
                'redirect_url' => route('admin.products.edit', $product)
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            foreach ($all_image as $value) {
                if ($value && Storage::exists($value)) {
                    Storage::delete($value);
                }
            }
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {

                if ($product->img_thumbnail && Storage::exists($product->img_thumbnail)) {
                    Storage::delete($product->img_thumbnail);
                }

                $galleries = $product->galleries;

                foreach ($galleries as $gallery) {
                    if ($gallery->image && Storage::exists($gallery->image)) {
                        Storage::delete($gallery->image);
                    }
                }

                $imgVariants = $product->variants;

                foreach ($imgVariants as $imgVariant) {
                    if ($imgVariant->image && Storage::exists($imgVariant->image)) {
                        Storage::delete($imgVariant->image);
                    }
                }

                $product->tags()->sync([]);
                $product->galleries()->delete();
                $product->variants()->delete();
                $product->delete();

            }, 3);

            return back()->with('success', 'thao tác thành công');
        } catch (\Throwable $th) {

            return back()->with('error', 'thao tác thất bại');
        }
    }

    private function handleData(Request $request)
    {
        $all_image = [];
        // dd($request->all());
        $dataProduct = $request->except(['product_variants', 'product_galleries', 'img_thumbnail', 'tags']);
        $dataProduct['is_active'] ??= 0;
        $dataProduct['is_hot_deal'] ??= 0;
        $dataProduct['is_good_deal'] ??= 0;
        $dataProduct['is_new'] ??= 0;
        $dataProduct['is_show_home'] ??= 0;
        $dataProduct['slug'] = Str::slug($dataProduct['name'] . '-' . $dataProduct['sku']);

        if ($request->hasFile('img_thumbnail')) {
            $dataProduct['img_thumbnail'] = Storage::put('products', $request->file('img_thumbnail'));
            $all_image[] = $dataProduct['img_thumbnail'];
        }

        $dataProductVariantsTmp = $request->product_variants;
        $dataProductVariants = [];
        foreach ($dataProductVariantsTmp as $key => $item) {
            $tmp = explode('-', $key);

            $dataProductVariants[] = [
                'product_size_id' => $tmp[0],
                'product_color_id' => $tmp[1],
                'quantity' => $item['quantity'],
                'image' => !empty($item['image']) ? Storage::put('products', $item['image']) : null,
            ];
            $all_image[] = $dataProductVariants[count($dataProductVariants) - 1]['image'];
        }

        $dataProductGalleriesTmp = $request->product_galleries ?? [];
        $dataProductGalleries = [];
        foreach ($dataProductGalleriesTmp as $item) {
            if (!empty($item)) {
                $dataProductGalleries[] = [
                    'image' => Storage::put('products', $item),
                ];
                $all_image[] = $dataProductGalleries[count($dataProductGalleries) - 1]['image'];
            }
        }

        $dataProductTags = $request->tags;

        return [
            $dataProduct,
            $dataProductTags,
            $dataProductGalleries,
            $dataProductVariants,
            $all_image,
        ];
    }
}