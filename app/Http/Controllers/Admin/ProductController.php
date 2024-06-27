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
        $all_image = [];
        // dd($request->all());
        $dataProduct = $request->except(['product_variants', 'product_galleries', 'tags', 'img_thumbnail']);
        $dataProductVariantsTmp = $request->product_variants;
        $dataProductTags = $request->tags;
        $dataProductGalleries = $request->product_galleries ?? [];
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

        $dataProductVariants = [];
        foreach ($dataProductVariantsTmp as $key => $value) {
            $tmp = explode('-', $key);

            $dataProductVariants[] = [
                'product_size_id' => $tmp[0],
                'product_color_id' => $tmp[1],
                'quantity' => $value['quantity'],
                'image' => $value['image'] ?? null,
            ];
        }

        try {
            DB::beginTransaction();

            /** @var Product $product */

            $product = Product::query()->create($dataProduct);

            foreach ($dataProductVariants as $dataProductVariant) {
                $dataProductVariant['product_id'] = $product->id;

                if ($dataProductVariant['image']) {
                    $dataProductVariant['image'] = Storage::put('products', $dataProductVariant['image']);
                    $all_image[] = $dataProductVariant['image'];
                }

                ProductVariant::query()->create($dataProductVariant);
            }

            $product->tags()->sync($dataProductTags);

            foreach ($dataProductGalleries as $value) {
                $all_image[] = $value;
                ProductGallery::query()->create([
                    'image' => Storage::put('products', $value),
                    'product_id' => $product->id,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')->with('success', 'thao tác thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            foreach ($all_image as $value) {
                if (Storage::exists($value)) {
                    Storage::delete($value);
                }
            }
            dd($all_image);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
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
}