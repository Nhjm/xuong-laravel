@extends('admin.layouts.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Basic Elements</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Basic Elements</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Input Example</h4>

                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-5">
                                <!--end col-->
                                <div class="col-md-5">

                                    <div class="form-floating">
                                        <input name="name" type="text" class="form-control"
                                            id="firstnamefloatingInput" placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">name</label>
                                    </div>


                                    <!--end col-->
                                    <div class="mt-3">
                                        <label for="labelInput" class="form-label">catalogue</label>
                                        <select name="catalogue_id" class="form-select rounded-pill mb-3"
                                            aria-label="Default select example">
                                            @foreach ($catalogues as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-floating">
                                        <input value="{{ strtoupper(Str::random(8)) }}" name="sku" type="text"
                                            class="form-control" id="firstnamefloatingInput"
                                            placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">sku</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input name="price_regular" type="number" min="0" value="0"
                                            class="form-control" id="firstnamefloatingInput"
                                            placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">price_regular</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input name="price_sale" type="number" min="0" value="0"
                                            class="form-control" id="firstnamefloatingInput"
                                            placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">price_sale</label>
                                    </div>
                                    <div class="mt-3">
                                        <label for="formFile" class="form-label">img_thumbnail</label>
                                        <input name="img_thumbnail" class="form-control" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    @php
                                        $is = [
                                            'is_active' => 'primary',
                                            'is_hot_deal' => 'danger',
                                            'is_good_deal' => 'warning',
                                            'is_new' => 'success',
                                            'is_show_home' => 'info',
                                        ];
                                    @endphp
                                    <div class="row">
                                        @foreach ($is as $key => $color)
                                            <div class="mt-3 col-md-3">
                                                <div class="form-check form-switch form-switch-{{ $color }}">
                                                    <input name="{{ $key }}" value="1" class="form-check-input"
                                                        type="checkbox" role="switch" checked>
                                                    <label class="form-check-label"
                                                        for="SwitchCheck2">{{ Str::convertCase($key, MB_CASE_TITLE) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">description</label>
                                        <textarea name="description" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">material</label>
                                        <textarea name="material" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">user_manual</label>
                                        <textarea name="user_manual" class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">content</label>
                                        <textarea name="content"></textarea>
                                    </div>

                                </div>

                                <!--end row-->
                            </div>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Biến thể</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Image</th>
                            </tr>
                            @foreach ($sizes as $sizeId => $sizeValue)
                                @php($rowspan = true)
                                @foreach ($colors as $colorId => $colorValue)
                                    <tr>
                                        @if ($rowspan)
                                            <td style="vertical-align: middle;" rowspan="{{ count($colors) }}">
                                                {{ $sizeValue }}</td>
                                        @endif
                                        @php($rowspan = false)
                                        <td>
                                            <div style="width: 50px; height: 50px; background: {{ $colorValue }}"></div>
                                        </td>
                                        <td><input type="number" value="0"
                                                name="product_variants[{{ $sizeId . '-' . $colorId }}][quantity]"
                                                id="" class="form-control"></td>
                                        <td><input type="file" class="form-control"
                                                name="product_variants[{{ $sizeId . '-' . $colorId }}][image]"
                                                id="">
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">galleries</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <input type="file" name="product_galleries[]" id="" class="form-control">
                        <input type="file" name="product_galleries[]" id="" class="form-control mt-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Tags</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <select name="tags[]" class="form-select" multiple>
                            @foreach ($tags as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-success">Thêm</button>
    </form>
@endsection

@section('script_libs')
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
