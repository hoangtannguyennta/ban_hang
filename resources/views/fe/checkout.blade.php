@extends('fe.layouts.home')

@section('page_title', 'Thanh toán')

<style>
    :root {
        --primary-black: #000000;
        --secondary-gray: #757575;
        --bg-input: #f8f9fa;
        --transition: all 0.3s ease-in-out;
    }

    /* 1. Layout tổng thể: Cực thoáng */
    .checkout-section {
        background: #ffffff;
        border: none;
        padding: 3rem;
        /* Padding rộng để tạo không gian sang trọng */
        border: 1px solid #e0e0e0;
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

    /* Tùy chỉnh hiển thị cho thẻ select */
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
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
        border-bottom-color: var(--primary-black);
        box-shadow: none;
        /* Bỏ đổ bóng xanh mặc định của bootstrap */
        outline: none;
    }

    /* 3. Label: Nhỏ, thanh mảnh phía trên */
    .form-label {
        font-size: 0.65rem;
        letter-spacing: 1px;
        font-weight: 800;
        color: #000;
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
        padding: 20px;
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
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .summary-product-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border: 1px solid #eee;
    }

    .summary-product-info {
        flex: 1;
    }

    .summary-product-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #000;
        display: block;
        margin-bottom: 4px;
    }

    .summary-product-price {
        font-weight: 400;
        color: #1a1a1a;
        font-size: 0.85rem;
    }

    /* Tinh chỉnh selector số lượng trong tóm tắt */
    .summary-qty-selector {
        display: flex;
        align-items: center;
        border: 1px solid #eee;
        margin-top: 8px;
        width: fit-content;
    }
    .summary-qty-btn {
        background: none;
        border: none;
        padding: 2px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: 0.2s;
    }
    .summary-qty-btn:hover { background: #f8f9fa; }
    .summary-qty-value {
        width: 30px;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        border-left: 1px solid #eee;
        border-right: 1px solid #eee;
    }

    .summary-remove {
        background: none;
        border: none;
        color: #888;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s;
    }
    .summary-remove:hover { color: #c0392b; }

    /* 5. Tổng thanh toán: To, rõ, không rườm rà */
    .checkout-total-row {
        padding-top: 2rem;
        margin-top: 1rem;
        border-top: none;
    }

    #checkoutTotal {
        font-weight: 200;
        /* Font mỏng nhưng cực to */
        font-size: 2.5rem;
        color: var(--primary-black);
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
        background: #333;
        transform: none;
        /* Không cần bay bổng, chỉ đổi màu */
        letter-spacing: 4px;
        /* Giãn chữ nhẹ khi hover */
    }
    
    .payment-method-box {
        border: 1px solid #eee;
        padding: 1rem;
        transition: var(--transition);
        cursor: pointer;
    }
    .payment-method-box:hover { border-color: #000; }
    .payment-method-box input { accent-color: #000; }

    .text-gold-gradient { color: #000 !important; background: none !important; -webkit-text-fill-color: initial !important; font-weight: 700; }

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
        <div class="text-center" style="margin-bottom: 50px;">
            <h1 class="display-5 font-heading"><span class="text-gold-gradient">Hoàn tất đặt hàng</span></h1>
            <p class="text-muted" style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.75rem;">Vui lòng kiểm
                tra lại thông tin trước khi xác nhận</p>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <form id="checkoutForm" class="checkout-section shadow-sm">
                    @csrf
                    <h4 class="font-heading mb-4"
                        style="border-left: 4px solid #000; padding-left: 1rem; font-weight: 700;">Thông tin giao
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

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label">Tỉnh / Thành phố</label>
                            <div class="input-group-custom mb-0">
                                <select name="province" id="province" class="form-control" required>
                                    <option value="">Chọn Tỉnh/Thành</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label">Quận / Huyện</label>
                            <div class="input-group-custom mb-0">
                                <select name="district" id="district" class="form-control" required disabled>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phường / Xã</label>
                            <div class="input-group-custom mb-0">
                                <select name="ward" id="ward" class="form-control" required disabled>
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 mt-4">
                        <label class="form-label">Số nhà, tên đường</label>
                        <div class="input-group-custom">
                            <i class="fas fa-map-marker-alt" style="top: 1.2rem; transform: none;"></i>
                            <textarea name="shipping_address" class="form-control" rows="3"
                                placeholder="Địa chỉ cụ thể (Số nhà, tên đường...)" required></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Phương thức thanh toán</label>
                        <div class="d-flex gap-3 mt-2">
                            <div class="payment-method-box flex-fill">
                                <input type="radio" name="payment_method" id="pay_cod" value="cod" checked>
                                <label for="pay_cod" class="ms-2 mb-0" style="font-size: 0.9rem; cursor: pointer;">Tiền mặt (COD)</label>
                            </div>
                            <div class="payment-method-box flex-fill">
                                <input type="radio" name="payment_method" id="pay_transfer" value="transfer">
                                <label for="pay_transfer" class="ms-2 mb-0" style="font-size: 0.9rem; cursor: pointer;">Chuyển khoản</label>
                            </div>
                        </div>
                    </div>

                    @if($activeQr)
                        <div id="qr_section" class="text-center" style=" display: none; border: 1px solid #eee; background: #fafafa; margin-bottom: auto; padding: 1rem">
                            <p class="small text-muted mb-3" style="letter-spacing: 1px;">QUÉT MÃ QR ĐỂ THANH TOÁN</p>
                            {{-- Sử dụng API VietQR để tạo mã QR động --}}
                            <img src="{{ $activeQr->images }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 180px; border: 5px solid #fff;">
                            <div class="text-start mx-auto" style="max-width: 280px; font-size: 0.8rem; line-height: 1.6;">
                                <p style="margin-bottom: 0.5rem;" class="mb-1"><strong>Ngân hàng:</strong> {{ $activeQr->bank_name }}</p>
                                <p style="margin-bottom: 0.5rem;" class="mb-1"><strong>Số TK:</strong> {{ $activeQr->account_number }}</p>
                                <p style="margin-bottom: 0;" class="mb-0"><strong>Chủ TK:</strong> {{ $activeQr->account_owner }}</p>
                            </div>
                        </div>
                    @endif

                    <input type="hidden" name="cart_data" id="cartDataInput">
                    <button type="submit" id="btnSubmit" class="btn-hero w-100 py-3" style="border:none;">
                        <span class="btn-text">XÁC NHẬN ĐẶT HÀNG</span>
                    </button>
                </form>
            </div>
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="order-summary-card shadow-sm">
                    <div class="summary-header">
                        <h3 class="text-uppercase" style="font-size: 1.2rem; font-weight: 700;">Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="py-2">
                        <div id="checkoutSummary"></div>
                        <div class="checkout-total-row d-flex justify-content-between align-items-end">
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
                    $summary.append(`
            <div class="summary-item">
                <img src="${item.image}" alt="${item.name}" class="summary-product-img">
                <div class="summary-product-info">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="summary-product-name">${item.name} ${item.size ? `<small class="text-muted">(Size: ${item.size})</small>` : ''}</span>
                        <button type="button" class="summary-remove btn-remove-item" data-id="${item.id}" data-size="${item.size || ''}">Xóa</button>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="summary-qty-selector">
                            <button type="button" class="summary-qty-btn btn-minus" data-id="${item.id}" data-size="${item.size || ''}">−</button>
                            <span class="summary-qty-value">${item.qty}</span>
                            <button type="button" class="summary-qty-btn btn-plus" data-id="${item.id}" data-size="${item.size || ''}">+</button>
                        </div>
                        <span class="summary-product-price">${new Intl.NumberFormat('vi-VN').format(item.price * item.qty)}₫</span>
                    </div>
                </div>
            </div>`);
                });
                $('#checkoutTotal').text(new Intl.NumberFormat('vi-VN').format(total) + '₫');

                // Chuẩn hóa dữ liệu giỏ hàng trước khi gửi lên Server
                // Đảm bảo 'id' truyền đi chính là ID sản phẩm trong Database (products.id)
                const formattedCart = cart.map(item => ({
                    id: item.id,      // ID của sản phẩm trong database
                    qty: item.qty,    // Số lượng
                    price: item.price, // Giá tại thời điểm đặt
                    size: item.size || null   // Đảm bảo size luôn tồn tại (null thay vì undefined)
                }));
                
                $('#cartDataInput').val(JSON.stringify(formattedCart));
            }

            renderSummary();

            // Xử lý thay đổi số lượng trong tóm tắt đơn hàng
            $(document).on('click', '.summary-qty-btn', function() {
                const id = $(this).data('id');
                const size = $(this).data('size') || null;
                const isPlus = $(this).hasClass('btn-plus');
                const index = cart.findIndex(item => item.id == id && (item.size == size || (!item.size && !size)));

                if (index !== -1) {
                    if (isPlus) {
                        cart[index].qty++;
                    } else if (cart[index].qty > 1) {
                        cart[index].qty--;
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderSummary();
                    if (typeof updateCartUI === 'function') updateCartUI();
                }
            });

            // Xử lý xóa sản phẩm khỏi giỏ hàng ngay tại trang checkout
            $(document).on('click', '.btn-remove-item', function() {
                const id = $(this).data('id');
                const size = $(this).data('size') || null;
                
                cart = cart.filter(item => !(item.id == id && (item.size == size || (!item.size && !size))));
                localStorage.setItem('cart', JSON.stringify(cart));
                
                if (cart.length === 0) {
                    window.location.href = "{{ route('fe.home') }}";
                } else {
                    renderSummary();
                    if (typeof updateCartUI === 'function') updateCartUI();
                }
            });

            // Hiển thị/ẩn mã QR dựa trên lựa chọn
            $('input[name="payment_method"]').on('change', function() {
                if (this.value === 'transfer') {
                    $('#qr_section').slideDown();
                } else {
                    $('#qr_section').slideUp();
                }
            });

            // Tải danh sách Tỉnh/Thành phố
            const $province = $('#province');
            const $district = $('#district');
            const $ward = $('#ward');

            fetch('https://provinces.open-api.vn/api/?depth=1')
                .then(res => res.json())
                .then(data => {
                    data.forEach(p => {
                        $province.append(`<option value="${p.name}" data-code="${p.code}">${p.name}</option>`);
                    });
                });

            // Khi thay đổi Tỉnh/Thành -> Tải Quận/Huyện
            $province.on('change', function() {
                const code = $(this).find(':selected').data('code');
                $district.empty().append('<option value="">Chọn Quận/Huyện</option>').prop('disabled', true);
                $ward.empty().append('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);

                if (code) {
                    fetch(`https://provinces.open-api.vn/api/p/${code}?depth=2`)
                        .then(res => res.json())
                        .then(data => {
                            data.districts.forEach(d => {
                                $district.append(`<option value="${d.name}" data-code="${d.code}">${d.name}</option>`);
                            });
                            $district.prop('disabled', false);
                        });
                }
            });

            // Khi thay đổi Quận/Huyện -> Tải Phường/Xã
            $district.on('change', function() {
                const code = $(this).find(':selected').data('code');
                $ward.empty().append('<option value="">Chọn Phường/Xã</option>').prop('disabled', true);

                if (code) {
                    fetch(`https://provinces.open-api.vn/api/d/${code}?depth=2`)
                        .then(res => res.json())
                        .then(data => {
                            data.wards.forEach(w => {
                                $ward.append(`<option value="${w.name}" data-code="${w.code}">${w.name}</option>`);
                            });
                            $ward.prop('disabled', false);
                        });
                }
            });

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
