@extends('admin.layouts.master')

@section('title')
    thêm mới
@endsection

@section('content')
    <form action="{{ route('admin.catalogues.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control"
                        id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input name="cover" class="form-control" type="file" id="formFile">
                </div>
            </div>
            <div class="form-check col-md-6">
                <input value="1" name="is_active" class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                    checked>
                <label class="form-check-label" for="flexCheckChecked">
                    Is Active
                </label>
            </div>
        </div>
        <button class="btn btn-primary">Thêm mới</button>
    </form>
@endsection
