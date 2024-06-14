
@extends('admin.layouts.master')

@section('title')
    Chi tiết
@endsection

@section('content')
    <a class="btn btn-primary" href="{{ route('admin.catalogues.index') }}">
        Quay lại</a>
    <table class="table">
        <tr>
            <th>TRƯỜNG</th>
            <th>GIÁ TRỊ</th>
        </tr>
        @foreach ($model->toArray() as $key => $value)
            <tr>
                {{-- @dd($model->toArray()) --}}
                <td> {{ $key }} </td>
                <td>
                    @if ($key === 'cover')
                        <img width="100px" src="{{ Storage::url($value) }}" alt="">
                    @elseif (Str::contains($key, 'is_'))
                        {!! $model ? '<span class="badge bg-primary">Yes</span>' : '<span class="badge bg-primary">No</span>' !!}
                    @else
                        {{ $value }}
                    @endif

                </td>
            </tr>
        @endforeach
    </table>
@endsection
