@extends('admin.layouts.master')

@section('tittle')
    Danh sách sản phẩm
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Datatables</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Datatables</li>
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


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Basic Datatables</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10px;">
                                    <div class="form-check">
                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th data-ordering="false">ID</th>
                                <th data-ordering="false">Name</th>
                                <th data-ordering="false">img_thumbnail</th>
                                <th data-ordering="false">sku</th>
                                <th data-ordering="false">catalogue</th>
                                <th data-ordering="false">price_regular</th>
                                <th data-ordering="false">price_sale</th>
                                <th data-ordering="false">view</th>
                                <th data-ordering="false">is_active</th>
                                <th data-ordering="false">is_hot_deal</th>
                                <th data-ordering="false">is_good_deal</th>
                                <th data-ordering="false">is_new</th>
                                <th data-ordering="false">is_show_home</th>
                                <th data-ordering="false">Tags</th>
                                <th data-ordering="false">created_at</th>
                                <th data-ordering="false">updated_at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input fs-15" type="checkbox" name="checkAll"
                                                value="option1">
                                        </div>
                                    </th>
                                    <td data-ordering="false">{{ $item->id }}</td>
                                    <td data-ordering="false">{{ $item->name }}</td>
                                    <td data-ordering="false">
                                        {{-- @dd($item) --}}
                                        @if (Str::contains($item->img_thumbnail, 'http'))
                                            <img width="100px" src="{{ $item->img_thumbnail }}" alt="">
                                        @else
                                            <img width="100px"
                                                src="{{ $item->img_thumbnail && Storage::exists($item->img_thumbnail) ? Storage::url($item->img_thumbnail) : null }}"
                                                alt="">
                                        @endif
                                    </td>
                                    <td data-ordering="false">{{ $item->sku }}</td>
                                    <td>{{ $item->catalogue->name }}</td>
                                    <td data-ordering="false">{{ $item->price_regular }}</td>
                                    <td data-ordering="false">{{ $item->price_sale }}</td>
                                    <td data-ordering="false">{{ $item->view }}</td>
                                    <td data-ordering="false">{!! $item->is_active
                                        ? '<span class="badge bg-success-subtle text-success text-uppercase">Yes</span>'
                                        : '<span class="badge bg-danger-subtle text-danger text-uppercase">No</span>' !!}</td>
                                    <td data-ordering="false">{!! $item->is_hot_deal
                                        ? '<span class="badge bg-success-subtle text-success text-uppercase">Yes</span>'
                                        : '<span class="badge bg-danger-subtle text-danger text-uppercase">No</span>' !!}</td>
                                    <td data-ordering="false">{!! $item->is_good_deal
                                        ? '<span class="badge bg-success-subtle text-success text-uppercase">Yes</span>'
                                        : '<span class="badge bg-danger-subtle text-danger text-uppercase">No</span>' !!}</td>
                                    <td data-ordering="false">{!! $item->is_new
                                        ? '<span class="badge bg-success-subtle text-success text-uppercase">Yes</span>'
                                        : '<span class="badge bg-danger-subtle text-danger text-uppercase">No</span>' !!}</td>
                                    <td data-ordering="false">{!! $item->is_show_home
                                        ? '<span class="badge bg-success-subtle text-success text-uppercase">Yes</span>'
                                        : '<span class="badge bg-danger-subtle text-danger text-uppercase">No</span>' !!}</td>
                                    <td data-ordering="false">
                                        @foreach ($item->tags as $tag)
                                            <span class="badge bg-info">{!! $tag->name !!}</span>
                                        @endforeach
                                    </td>
                                    <td data-ordering="false">{{ $item->created_at }}</td>
                                    <td data-ordering="false">{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="#!" class="dropdown-item"><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                                </li>
                                                <li><a href="{{ route('admin.products.edit', $item) }}"
                                                        class="dropdown-item edit-item-btn"><i
                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        Edit</a></li>
                                                <li>
                                                    <form action="{{ route('admin.products.destroy', $item) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item remove-item-btn"
                                                            onclick="return confirm('chắc chắn xóa?')">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div>
    <!--end row-->
@endsection

@section('style_libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}

    <style>
        /* CSS cho cột "Name" */
        .table td:nth-child(3),
        .table th:nth-child(3) {
            /* Thiết lập cho phép cột "Name" xuống dòng */
            white-space: normal !important;
            /* Cho phép xuống dòng */
            word-wrap: break-word;
            /* Tách từ khi vượt quá kích thước cột */
            max-width: none !important;
            /* Bỏ giới hạn chiều rộng */
        }
    </style>
@endsection

@section('script_libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('theme/admins/velzon/assets/js/pages/datatables.init.js') }}"></script>

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
@endsection
