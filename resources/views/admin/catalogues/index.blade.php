@extends('admin.layouts.master')

@section('title')
    danh sách
@endsection

@section('content')
    <a class="btn btn-primary" href="{{ route('admin.catalogues.create') }}">Thêm mới</a>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>COVER</th>
            <th>IS ACTIVE</th>
            <th>CREATED AT</th>
            <th>UPDATED AT</th>
            <th>ACTION</th>
            <td></td>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td> {{ $item->id }} </td>
                <td> {{ $item->name }} </td>
                <td><img width="100px" src="{{ Storage::url($item->cover) }}" alt=""></td>
                <td> {!! $item->is_active ? '<span class="badge bg-primary">Yes</span>' : '<span class="badge bg-primary">No</span>' !!} </td>
                <td> {{ $item->created_at }} T</td>
                <td> {{ $item->updated_at }} </td>
                <td>
                    <a class="btn btn-info" href="{{ route('admin.catalogues.edit', $item->id) }}">Sửa</a>
                    <a class="btn btn-secondary" href="{{ route('admin.catalogues.show', $item->id) }}">Chi tiết</a>
                    <form action="{{ route('admin.catalogues.destroy', $item->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" onclick="return confirm('chắn chắn xóa?')">Xóa</button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
    {{ $data->links() }}
@endsection
