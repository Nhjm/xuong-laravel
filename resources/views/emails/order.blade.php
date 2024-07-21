<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Xin chào, {{ $user->name }}</h1>
    <p>Đơn hàng của bạn đã được tạo thành công.</p>
    <p>Chi tiết đơn hàng:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->id }}</li>
        <li>Tổng giá trị: {{ $order->total_price }} VND</li>
        <!-- Thêm thông tin chi tiết đơn hàng khác nếu cần -->
    </ul>
    <p><a href="{{ url('/orders/' . $order->id) }}">Xem Đơn Hàng</a></p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>

</html>
