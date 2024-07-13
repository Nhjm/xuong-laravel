@extends('admin.layouts.master')

@section('title')
    Sửa
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

    @session('error')
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endsession
    @session('success')
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endsession

    <form id="form_update" action="{{ route('admin.products.update', $product) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                        <input value="{{ $product->name }}" name="name" type="text"
                                            class="form-control" id="firstnamefloatingInput"
                                            placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">name</label>
                                    </div>


                                    <!--end col-->
                                    <div class="mt-3">
                                        <label for="labelInput" class="form-label">catalogue</label>
                                        <select name="catalogue_id" class="form-select rounded-pill mb-3"
                                            aria-label="Default select example">
                                            @foreach ($catalogues as $id => $name)
                                                <option @selected($id == $product->catalogue_id) value="{{ $id }}">
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-floating">
                                        <input value="{{ $product->sku }}" name="sku" type="text"
                                            class="form-control" id="firstnamefloatingInput"
                                            placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">sku</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input name="price_regular" type="number" min="0"
                                            value="{{ $product->price_regular }}" class="form-control"
                                            id="firstnamefloatingInput" placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">price_regular</label>
                                    </div>
                                    <div class="form-floating mt-3">
                                        <input name="price_sale" type="number" min="0"
                                            value="{{ $product->price_sale }}" class="form-control"
                                            id="firstnamefloatingInput" placeholder="Enter your firstname">
                                        <label for="firstnamefloatingInput">price_sale</label>
                                    </div>
                                    <div class="mt-3">
                                        {{-- <label for="formFile" class="form-label">img_thumbnail</label>
                                        <input name="img_thumbnail" class="form-control" type="file" id="formFile"> --}}

                                        <div class="card-header">
                                            <h4 class="card-title mb-0">img_thumbnail</h4>
                                        </div><!-- end card header -->

                                        <div class="card-body" style="width: 100%;">
                                            <p class="text-muted">FilePond is a JavaScript library that optimizes
                                                multiple images for faster uploads and offers a great, accessible, silky
                                                smooth user experience.</p>
                                            <input type="file" class="filepond filepond-input-multiple" multiple
                                                data-allow-reorder="true" data-max-file-size="3MB" data-max-files="1">
                                            <img id="img_thumbnail_old" style="margin-top: 20px; border-radius: 10px"
                                                width="100%" src="{{ Storage::url($product->img_thumbnail) }}"
                                                alt="">
                                        </div>
                                        <!-- end card body -->

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
                                                    <input name="{{ $key }}" value="1"
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        @checked($product->$key == 1)>
                                                    <label class="form-check-label"
                                                        for="SwitchCheck2">{{ Str::convertCase($key, MB_CASE_TITLE) }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">description</label>
                                        <textarea name="description" class="form-control" id="exampleFormControlTextarea5" rows="3">{{ $product->description }}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">material</label>
                                        <textarea name="material" class="form-control" id="exampleFormControlTextarea5" rows="3">{{ $product->material }}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">user_manual</label>
                                        <textarea name="user_manual" class="form-control" id="exampleFormControlTextarea5" rows="3">{{ $product->user_manual }}</textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label for="exampleFormControlTextarea5" class="form-label">content</label>
                                        <textarea name="content">{{ $product->content }}</textarea>
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
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Thuộc tính</button>
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Biến thể</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Thuộc tính</h4>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <div class="mt-3">
                                    <label class="form-label" for="">Sizes</label>
                                    <select id="sizes" name="sizes[]" multiple="multiple">
                                        @foreach ($sizes as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label" for="">Colors</label>
                                    <select id="colors" name="colors[]" multiple="multiple">
                                        @foreach ($colors as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" id="tao_bien_the" class="btn btn-success mt-4">Tạo biến
                                    thể</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                tabindex="0">
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
                                    <tbody id="bien_the">
                                        @foreach ($product_variants as $variant)
                                            {{-- @dd($variant) --}}
                                            {{-- @foreach ($product_sizes as $sizeId => $sizeValue) --}}
                                            @php($rowspan = true)
                                            {{-- @foreach ($product_colors as $colorId => $colorValue) --}}
                                            <tr>
                                                {{-- @if ($rowspan)
                                    <td style="vertical-align: middle;" rowspan="{{ count($product_colors) }}">
                                        {{ $sizeValue }}</td>
                                    @endif
                                    @php($rowspan = false) --}}

                                                <td style="vertical-align: middle;">
                                                    {{ $variant->size->name }}</td>
                                                <td>
                                                    <div style="width: 50px; height: 50px; background: {{ $variant->color->name }}"
                                                        data-color_name="{{ $variant->color->name }}">
                                                    </div>
                                                </td>
                                                <td><input type="number" value="{{ $variant->quantity }}"
                                                        name="product_variants[{{ $variant->product_size_id . '-' . $variant->product_color_id }}][quantity]"
                                                        id="" class="form-control"></td>
                                                <td><input type="file" class="form-control"
                                                        name="product_variants[{{ $variant->product_size_id . '-' . $variant->product_color_id }}][image]"
                                                        id="">
                                                    <img width="100px" src="{{ Storage::url($variant->image) }}"
                                                        alt="">
                                                </td>
                                            </tr>
                                            {{-- @endforeach
                                @endforeach --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                        {{-- <input type="file" name="product_galleries" id="" class="form-control"> --}}
                        {{-- <input type="hidden" name="product_galleries[]" id="product_galleries"
                            class="form-control mt-3"> --}}
                    </div>
                    <div class="card-body">
                        {{-- <div id="product_galleries"></div> --}}
                        <p class="text-muted">DropzoneJS is an open source library that provides drag’n’drop file uploads
                            with image previews.</p>

                        <div class="dropzone">
                            <!-- Phần thay thế nếu trình duyệt không hỗ trợ Drag & Drop -->
                            <div class="fallback">
                                <input name="product_gallerie_news[]" type="file" multiple="multiple">
                            </div>
                            <!-- Phần thông báo khi kéo thả hoặc click để tải lên -->
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>
                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>
                        @foreach ($product_galleries as $gallerie)
                            <ul class="list-unstyled mb-0">
                                <li class="mt-2">
                                    <!-- Mẫu xem trước tệp sẽ được sử dụng -->
                                    {{-- @dd($product_galleries) --}}
                                    <div class="border rounded">
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 me-3">
                                                <!-- Hình ảnh xem trước của tệp sẽ được hiển thị tại đây -->
                                                <div class="avatar-sm bg-light rounded"
                                                    style="overflow: hidden; height: 5rem; width: 9rem">
                                                    <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                        src="{{ Storage::url($gallerie->image) }}"
                                                        alt="Dropzone-Image" />
                                                    <input type="hidden" name="product_galleries_old[]"
                                                        value="{{ $gallerie->image }}">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="pt-1 ">
                                                    <span class="badge badge-label bg-danger"><i></i> Ảnh cũ
                                                    </span>
                                                    {{-- <h5 class="fs-14 mb-1">&nbsp;</h5>
                                                    <!-- Kích thước của tệp sẽ được hiển thị tại đây -->
                                                    <p class="fs-13 text-muted mb-0"></p>
                                                    <!-- Thông báo lỗi (nếu có) sẽ được hiển thị tại đây -->
                                                    <strong class="error text-danger"></strong> --}}
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <!-- Nút xóa để loại bỏ tệp đã tải lên khỏi danh sách -->
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                            <li class="mt-2" id="dropzone-preview-list">
                                <!-- Mẫu xem trước tệp sẽ được sử dụng -->
                                {{-- @dd($product_galleries) --}}
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-shrink-0 me-3">
                                            <!-- Hình ảnh xem trước của tệp sẽ được hiển thị tại đây -->
                                            <div class="avatar-sm bg-light rounded"
                                                style="overflow: hidden; height: 5rem; width: 9rem">
                                                <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                    src="{{ asset('theme/admins/velzon/assets/images/new-document.png') }}"
                                                    alt="Dropzone-Image" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <!-- Tên tệp sẽ được hiển thị tại đây -->
                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                <!-- Kích thước của tệp sẽ được hiển thị tại đây -->
                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                <!-- Thông báo lỗi (nếu có) sẽ được hiển thị tại đây -->
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <!-- Nút xóa để loại bỏ tệp đã tải lên khỏi danh sách -->
                                            <button type="button" data-dz-remove
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <!-- end dropzon-preview -->
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
                        <select id="tags" name="tags[]" class="form-select" multiple="multiple">
                            @foreach ($tags as $id => $name)
                                <option value="{{ $id }}" @selected(in_array($id, $product_tags))>{{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <button id="btn_submit" type="submit" class="btn btn-success">Sửa</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quay lại</a>

    </form>
@endsection


@section('style_libs')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('theme/admins/velzon/assets/libs/dropzone/dropzone.css') }}"
        type="text/css" />

    <!-- Filepond css -->
    <link rel="stylesheet" href="{{ asset('theme/admins/velzon/assets/libs/filepond/filepond.min.css') }}"
        type="text/css" />
    <link rel="stylesheet"
        href="{{ asset('theme/admins/velzon/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
@endsection


@section('scripts')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection

@section('script_libs')
    <script src="https://cdn.ckeditor.com/4.9.0/full/ckeditor.js"></script>
    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="{{ asset('theme/admins/velzon/assets/js/pages/select2.init.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            // Khởi tạo Select2 cho sizes và colors với tùy chọn allowClear
            $('#sizes').select2({
                allowClear: true
            });
            $('#colors').select2({
                allowClear: true
            });
            $('#tags').select2({
                allowClear: true
            });

            // Mảng lưu trữ các biến thể đã có
            var bien_the_da_co = [];

            // Lặp qua các hàng trong bảng biến thể (nếu có) để lấy các id đã tồn tại
            $('#bien_the tr').each(function() {
                var sizeName = $(this).find('td:eq(0)').text().trim();
                var colorName = $(this).find('td:eq(1) div').attr('data-color_name').trim();
                bien_the_da_co.push(sizeName + '-' + colorName);
            });

            // console.log(bien_the_da_co);


            // Bắt sự kiện click vào nút "Tạo biến thể"
            $('#tao_bien_the').on('click', function() {
                alert('Đã tạo biến thể thành công!');

                var sizes = [];
                var colors = [];

                // Lặp qua các tùy chọn đã chọn từ dropdown Sizes và lưu vào mảng sizes
                $('#sizes option:selected').each(function() {
                    var option = {
                        id: $(this).val(), // Lấy giá trị id của option
                        name: $(this).text() // Lấy nội dung hiển thị của option
                    };
                    sizes.push(option); // Thêm option vào mảng sizes
                });

                // Lặp qua các tùy chọn đã chọn từ dropdown Colors và lưu vào mảng colors
                $('#colors option:selected').each(function() {
                    var option = {
                        id: $(this).val(), // Lấy giá trị id của option
                        name: $(this).text() // Lấy nội dung hiển thị của option
                    };
                    colors.push(option); // Thêm option vào mảng colors
                });

                // Lặp qua mảng sizes và mảng colors để tạo các hàng mới cho bảng biến thể
                sizes.forEach(function(size) {
                    colors.forEach(function(color) {
                        // Tạo id cho biến thể
                        var variantId = size.name + '-' + color.name;

                        // Kiểm tra xem biến thể đã tồn tại trong danh sách cũ chưa
                        if (bien_the_da_co.includes(variantId)) {
                            // Nếu đã tồn tại, bỏ qua và không tạo lại
                            // console.log('Biến thể đã tồn tại: ' + variantId);
                            return; // Bỏ qua biến thể này và chuyển sang biến thể tiếp theo
                        }

                        // Tạo HTML cho mỗi biến thể sản phẩm
                        var bien_the_html =
                            `<tr>
                                <td style="vertical-align: middle;">${size.name}</td>
                                <td><div style="width: 50px; height: 50px; background: ${color.name};"></div></td>
                                <td><input type="number" value="1" name="product_variants[${size.id}-${color.id}][quantity]" class="form-control"></td>
                                <td><input type="file" class="form-control" name="product_variants[${size.id}-${color.id}][image]"></td>
                            </tr>`;

                        // Thêm HTML của biến thể vào bảng biến thể
                        $('#bien_the').append(bien_the_html);

                        // Thêm id biến thể mới vào mảng bien_the_da_co
                        bien_the_da_co.push(variantId);

                    });
                });
            });
        });
    </script>

    <!-- dropzone min -->
    <script src="{{ asset('theme/admins/velzon/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <!-- filepond js -->
    <script src="{{ asset('theme/admins/velzon/assets/libs/filepond/filepond.min.js') }}"></script>
    <script
        src="{{ asset('theme/admins/velzon/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admins/velzon/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admins/velzon/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script
        src="{{ asset('theme/admins/velzon/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}">
    </script>

    {{-- <script src="{{ asset('theme/admins/velzon/assets/js/pages/form-file-upload.init.js') }}"></script> --}}

    <script>
        var previewTemplate,
            dropzone,
            dropzonePreviewNode = document.querySelector("#dropzone-preview-list"),
            inputMultipleElements =
            ((dropzonePreviewNode.id = ""),
                dropzonePreviewNode &&
                ((previewTemplate = dropzonePreviewNode.parentNode.innerHTML),
                    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode),
                    (myDropzone = new Dropzone(".dropzone", {
                        url: "null",
                        autoProcessQueue: false,
                        previewTemplate: previewTemplate,
                        previewsContainer: "#dropzone-preview",
                        acceptedFiles: 'image/*', // Chỉ chấp nhận tệp hình ảnh
                        thumbnailWidth: null,
                        resizeQuality: 1,
                    }))),
                //FilePond
                FilePond.registerPlugin(
                    FilePondPluginFileEncode,
                    FilePondPluginFileValidateSize,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginImagePreview
                ),
                document.querySelectorAll("input.filepond-input-multiple")
                //end_FilePond
            );
        //FilePond
        // Tạo đối tượng FilePond và lưu trữ nó trong một biến
        const inputElements = document.querySelectorAll('.filepond');
        const ponds = Array.from(inputElements).map(inputElement => FilePond.create(inputElement));

        // Tạo đối tượng FilePond cho một phần tử cụ thể và lưu trữ nó trong một biến
        const circlePond = FilePond.create(document.querySelector(".filepond-input-multiple"))
        // Lắng nghe sự kiện khi thêm file
        circlePond.on('addfile', (error, file) => {
            // Nếu không có lỗi và file đã được thêm
            if (!error) {
                // Ẩn div uploadInstruction
                document.getElementById('img_thumbnail_old').style.display = 'none';
            } else {
                console.error('Lỗi khi thêm file vào FilePond:', error);
            }
        });

        // Lắng nghe sự kiện khi xóa file
        circlePond.on('removefile', (error, file) => {
            // Kiểm tra số lượng file trong FilePond
            const files = circlePond.getFiles();
            if (files.length === 0) {
                // Hiển thị lại div uploadInstruction
                document.getElementById('img_thumbnail_old').style.display = 'block';
            }
        });

        //end_FilePond
        document.querySelector("#form_update").addEventListener("submit", function(e) {
            e.preventDefault();
            e.stopPropagation();

            var form = document.getElementById("form_update");
            var formData = new FormData(form);

            // Danh sách các key muốn loại bỏ
            //do filepond tạo ra input file có name=filepond nên xóa khi upload
            const keysToRemove = ['filepond'];
            // Lặp qua formData và xóa các key không mong muốn
            keysToRemove.forEach(key => formData.delete(key))

            // Thêm các tệp từ Dropzone vào formData
            myDropzone.getAcceptedFiles().forEach(function(file) {
                formData.append('product_galleries[]', file);
            });

            // Lấy tất cả các tệp từ FilePond và thêm vào FormData
            // circlePond.getFiles().forEach(file => {
            //     console.log(file.file);
            //     formData.append('img_thumbnail', file.file);
            // });
            const filePondFiles = circlePond.getFiles();
            if (filePondFiles.length > 0) {
                formData.append('img_thumbnail', filePondFiles[0].file);
            }
            // console.log(filePondFiles.length);

            // Gửi formData qua fetch
            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Kiểm tra kết nối mạng ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    if (data.success && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        console.log('lỗi controller: ');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        });
    </script>

    <script>
        // Lấy tất cả các button "Delete" và lặp qua từng button
        var deleteButtons = document.querySelectorAll('.delete');
        // console.log(deleteButtons);
        deleteButtons.forEach(function(button) {
            // Thêm sự kiện click cho mỗi button
            button.addEventListener('click', function() {
                // Lấy phần tử <ul> cha của button được click
                var ulElement = button.closest('ul');

                // Xóa phần tử <ul> khỏi DOM
                ulElement.remove();
            });
        });
    </script>
@endsection
