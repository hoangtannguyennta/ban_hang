@extends('fe.layouts.home')

@section('page_title', 'Thanh toán')

<style>
    :root {
        --gold: #c8973e;
        --gold-light: #f1dfad;
        --bg-input: #f8f9fa;
        --transition: all 0.3s ease-in-out;
    }

    /* 1. Layout tổng thể: Cực thoáng */
    .checkout-section {
        background: #ffffff;
        border: none;
        padding: 4rem;
        /* Padding rộng để tạo không gian sang trọng */
        border-radius: 40px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.04);
    }

    .checkout-section h4 {
        font-weight: 300;
        /* Font mỏng cho tinh tế */
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-bottom: 4rem !important;
        text-align: center;
        color: #1a1a1a;
    }

    /* 2. Input Full-width & Tinh giản */
    .input-group-custom {
        position: relative;
        margin-bottom: 3rem;
        /* Khoảng cách giữa các ô rộng ra */
        width: 100%;
    }

    /* Bỏ icon hoàn toàn cho sạch */
    .input-group-custom i {
        display: none;
    }

    .form-control {
        width: 100%;
        border: none;
        border-bottom: 2px solid #eee;
        /* Chỉ để lại đường gạch chân */
        border-radius: 0;
        /* Bỏ bo góc ô input */
        padding: 1rem 0;
        /* Chỉ padding trên dưới */
        font-size: 1.1rem;
        background-color: transparent;
        transition: var(--transition);
        color: #1a1a1a;
    }

    /* Hiệu ứng khi click vào ô: Đường gạch chân chạy màu vàng */
    .form-control:focus {
        background-color: transparent;
        border-bottom-color: var(--gold);
        box-shadow: none;
        /* Bỏ đổ bóng xanh mặc định của bootstrap */
        outline: none;
    }

    /* 3. Label: Nhỏ, thanh mảnh phía trên */
    .form-label {
        font-size: 0.65rem;
        letter-spacing: 2px;
        font-weight: 800;
        color: #bbb;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
    }

    /* 4. Card Tóm tắt: Trong suốt & Sang trọng */
    .order-summary-card {
        position: sticky;
        top: 150px;
        background: transparent;
        border: none;
        box-shadow: none;
        /* Bỏ shadow để trông tiệp vào nền */
    }

    .summary-header {
        background: transparent;
        padding: 0 0 1.5rem 0;
        border-bottom: 2px solid #1a1a1a;
        text-align: left;
        padding-top: 1rem;
    }

    .summary-header h3 {
        font-weight: 300;
        font-size: 1.8rem;
        letter-spacing: 2px;
    }

    .summary-item {
        padding: 1.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .summary-product-name {
        font-size: 1rem;
        font-weight: 400;
        color: #666;
    }

    .summary-product-price {
        font-weight: 600;
        color: #1a1a1a;
    }

    /* 5. Tổng thanh toán: To, rõ, không rườm rà */
    .checkout-total-row {
        padding-top: 2rem;
        margin-top: 1rem;
        border-top: none;
    }

    #checkoutTotal {
        font-weight: 200;
        /* Font mỏng nhưng cực to */
        font-size: 3rem;
        color: var(--gold);
        letter-spacing: -2px;
    }

    /* 6. Nút xác nhận: Tối giản hoàn toàn */
    .btn-hero {
        background: #1a1a1a;
        /* Nút màu đen tối giản */
        color: #fff;
        border-radius: 0;
        /* Nút vuông vức sang trọng */
        padding: 1.5rem !important;
        font-weight: 300;
        letter-spacing: 3px;
        transition: var(--transition);
        border: none;
        margin-top: 2rem;
    }

    .btn-hero:hover {
        background: var(--gold);
        transform: none;
        /* Không cần bay bổng, chỉ đổi màu */
        letter-spacing: 5px;
        /* Giãn chữ nhẹ khi hover */
    }

    /* Textarea tinh chỉnh */
    textarea.form-control {
        min-height: 80px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkout-section {
            padding: 2rem 1.5rem;
        }

        #checkoutTotal {
            font-size: 2.5rem;
        }
    }
</style>

@section('content')
    <main class="container py-5" style="margin-top: 100px;">
        <div class="text-center mb-5">
            <h1 class="display-5 font-heading"><span class="text-gold-gradient">Hoàn tất đặt hàng</span></h1>
            <p class="text-muted" style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.75rem;">Vui lòng kiểm
                tra lại thông tin trước khi xác nhận</p>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <form id="checkoutForm" class="checkout-section shadow-sm">
                    @csrf
                    <h4 class="font-heading mb-4"
                        style="border-left: 4px solid var(--gold); padding-left: 1rem; font-weight: 700;">Thông tin giao
                        hàng</h4>

                    <div class="mb-3">
                        <label class="form-label">Họ tên khách hàng</label>
                        <div class="input-group-custom">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ và tên..."
                                required value="{{ auth()->user()->name ?? '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <div class="input-group-custom">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="phone_number" class="form-control"
                                placeholder="Số điện thoại liên hệ..." required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Địa chỉ nhận hàng</label>
                        <div class="input-group-custom">
                            <i class="fas fa-map-marker-alt" style="top: 1.2rem; transform: none;"></i>
                            <textarea name="shipping_address" class="form-control" rows="3"
                                placeholder="Địa chỉ cụ thể (Số nhà, đường, phường/xã...)" required></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="cart_data" id="cartDataInput">
                    <button type="submit" id="btnSubmit" class="btn-hero w-100 py-3" style="border:none;">
                        <span class="btn-text">XÁC NHẬN ĐẶT HÀNG</span>
                    </button>
                </form>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="order-summary-card shadow-sm">
                    <div class="summary-header">
                        <h3>Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="p-4">
                        <div id="checkoutSummary"></div>
                        <div class="checkout-total-row d-flex justify-content-between align-items-center">
                            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem;">Tổng thanh
                                toán</span>
                            <h2 class="text-gold-gradient mb-0" id="checkoutTotal" style="font-weight: 700;">0₫</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Giỏ hàng trống!');
                window.location.href = "{{ route('fe.home') }}";
            }

            function renderSummary() {
                const $summary = $('#checkoutSummary');
                let total = 0;
                $summary.empty();
                cart.forEach(item => {
                    total += item.price * item.qty;
                    $summary.append(`<div class="summary-item">
                <span class="summary-product-name">${item.name} <strong class="ms-1 text-gold">x${item.qty}</strong></span>
                <span class="summary-product-price">${new Intl.NumberFormat('vi-VN').format(item.price * item.qty)}₫</span>
            </div>`);
                });
                $('#checkoutTotal').text(new Intl.NumberFormat('vi-VN').format(total) + '₫');

                // Chuẩn hóa dữ liệu giỏ hàng trước khi gửi lên Server
                // Đảm bảo 'id' truyền đi chính là ID sản phẩm trong Database (products.id)
                const formattedCart = cart.map(item => ({
                    id: item.id,      // ID của sản phẩm trong database
                    qty: item.qty,    // Số lượng
                    price: item.price // Giá tại thời điểm đặt
                }));
                
                $('#cartDataInput').val(JSON.stringify(formattedCart));
            }

            renderSummary();

            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSubmit');
                $btn.prop('disabled', true).css('opacity', '0.7').find('.btn-text').text('ĐANG XỬ LÝ...');

                $.ajax({
                    url: "{{ route('fe.checkout.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.success) {
                            localStorage.removeItem('cart');
                            window.location.href = res.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                        $btn.prop('disabled', false).css('opacity', '1').find('.btn-text').text(
                            'XÁC NHẬN ĐẶT HÀNG');
                    }
                });
            });
        });
    </script>
@endpush
