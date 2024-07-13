<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <table class="table">
            {{-- @dd(session()->all()) --}}
            <tr>
                <th>Name</th>
                <th>Giá thường</th>
                <th>Giá sale</th>
                <th>Color</th>
                <th>Size</th>
                <th>số lượng</th>
            </tr>
            @session('cart')
                @foreach (session('cart') as $item)
                    {{-- @dd($item) --}}
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price_regular'] }}</td>
                        <td>{{ $item['price_sale'] }}</td>
                        <td>{{ $item['color']['name'] }}</td>
                        <td>{{ $item['size']['name'] }}</td>
                        <td>{{ $item['product_quantity'] }}</td>
                    </tr>
                @endforeach
            @endsession
        </table>
        <h2>Tổng tiền: {{ number_format($total_price) }} vnđ</h2>
        <form class="form-control w-50" action="{{ route('order.add') }}" method="post">
            @csrf
            <div class="mt-3">
                <label for="" class="form-label">user_name</label>
                <input value="{{ Auth::user()?->name }}" class="form-control" type="text" name="user_name"
                    id="">
            </div>
            <div class="mt-3">
                <label for="" class="form-label">user_email</label>
                <input value="{{ Auth::user()?->name }}" class="form-control" type="text" name="user_email"
                    id="">
            </div>
            <div class="mt-3">
                <label for="" class="form-label">user_phone</label>
                <input value="{{ Auth::user()?->name }}" class="form-control" type="text" name="user_phone"
                    id="">
            </div>
            <div class="mt-3">
                <label for="" class="form-label">user_address</label>
                <input value="{{ Auth::user()?->name }}" class="form-control" type="text" name="user_address"
                    id="">
            </div>
            <div class="mt-3">
                <label for="" class="form-label">user_notes</label>
                <input value="{{ Auth::user()?->name }}" class="form-control" type="text" name="user_notes"
                    id="">
            </div>
            <button class="btn btn-success mt-3">Đặt hàng</button>
        </form>
    </div>
</body>

</html>
