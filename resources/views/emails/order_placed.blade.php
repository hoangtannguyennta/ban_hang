<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận đơn hàng</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .email-wrapper { width: 100%; padding: 20px 0; }
        .email-content { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header { background-color: #2c3e50; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        .body-content { padding: 30px; }
        .greeting { font-size: 18px; margin-bottom: 20px; }
        .order-info { background-color: #f9f9f9; border-left: 4px solid #3498db; padding: 15px; margin-bottom: 25px; }
        .order-info p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        th { background-color: #ecf0f1; color: #2c3e50; font-weight: 600; text-align: left; padding: 12px; border-bottom: 2px solid #bdc3c7; }
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .text-right { text-align: right; }
        .product-name { font-weight: 600; color: #2c3e50; }
        .product-meta { font-size: 12px; color: #7f8c8d; }
        .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; display: block; }
        .total-section { border-top: 2px solid #2c3e50; padding-top: 15px; }
        .total-row { display: flex; justify-content: flex-end; font-size: 18px; }
        .total-label { font-weight: 600; margin-right: 20px; }
        .total-amount { color: #e74c3c; font-weight: bold; }
        .footer { background-color: #f4f4f4; color: #7f8c8d; padding: 20px; text-align: center; font-size: 13px; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #3498db; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="header">
                <h1>Xác Nhận Đơn Hàng</h1>
            </div>
            
            <div class="body-content">
                <div class="greeting">
                    Chào <strong>{{ $order->name }}</strong>,
                </div>
                <p>Cảm ơn bạn đã tin tưởng và đặt hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được tiếp nhận và đang trong quá trình xử lý.</p>

                <div class="order-info">
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
                </div>

                <h3>Chi tiết sản phẩm:</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 70px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th class="text-right">SL</th>
                            <th class="text-right">Đơn giá</th>
                            <th class="text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product->images)
                                    <img src="{{ $item->product->images }}" alt="{{ $item->product->name }}" class="product-img">
                                @endif
                            </td>
                            <td>
                                <div class="product-name">{{ $item->product->name }}</div>
                                @if($item->size)
                                    <div class="product-meta">Kích cỡ: {{ $item->size }}</div>
                                @endif
                            </td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">{{ number_format($item->price) }}đ</td>
                            <td class="text-right">{{ number_format($item->price * $item->quantity) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="total-section">
                    <table style="margin-bottom: 0;">
                        <tr>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td class="text-right" style="border: none; font-weight: 600; font-size: 18px;">Tổng cộng:</td>
                            <td class="text-right" style="border: none; color: #e74c3c; font-weight: bold; font-size: 20px;">
                                {{ number_format($order->total_amount) }}đ
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <p>Chúng tôi sẽ sớm liên hệ với bạn qua số điện thoại <strong>{{ $order->phone_number }}</strong> để xác nhận thời gian giao hàng cụ thể.</p>
                    <p>Nếu bạn có bất kỳ thắc mắc nào, vui lòng phản hồi email này hoặc gọi hotline của chúng tôi.</p>
                </div>
                
                <div style="text-align: center;">
                    <a href="{{ url('/') }}" class="btn">Tiếp tục mua sắm</a>
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Cửa hàng của bạn. All rights reserved.</p>
                <p>Địa chỉ: Đường ABC, Quận XYZ, TP. Huế</p>
            </div>
        </div>
    </div>
</body>
</html>