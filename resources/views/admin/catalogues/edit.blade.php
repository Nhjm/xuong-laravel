@extends('admin.layouts.master')

@section('title')
    Sửa
@endsection

@section('content')
    <form action="{{ route('admin.catalogues.update', $model->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input name="name" value="{{ $model->name }}" type="text" class="form-control"
                        id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input name="cover" class="form-control" type="file" id="formFile">
                    <img width="100px" src="{{ Storage::url($model->cover) }}" alt="">
                </div>
            </div>
            <div class="form-check col-md-6">
                <input value="1" name="is_active" class="form-check-input" type="checkbox" value=""
                    id="flexCheckChecked" @checked($model->is_active)>
                <label class="form-check-label" for="flexCheckChecked">
                    Is Active
                </label>
            </div>
        </div>
        <button class="btn btn-primary">Sửa</button>
        <a class="btn btn-secondary" href="{{ route('admin.catalogues.index') }}">Quay lại</a>
    </form>
@endsection
