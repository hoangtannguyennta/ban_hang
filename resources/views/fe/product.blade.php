@extends('fe.layouts.home')

@section('page_title')
    {{ $product->name }}
@endsection

@section('content')
    <style>
        .product-detail {
            padding-top: 50px;
            padding-bottom: 80px;
        }
        .breadcrumb {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 40px;
            color: #888;
        }
        .breadcrumb a { color: #888; text-decoration: none; }
        .breadcrumb span.sep { margin: 0 10px; }
        .breadcrumb span:last-child { color: #000; font-weight: 600; }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }
        .detail-gallery img {
            width: 100%;
            height: auto;
            display: block;
            background: #f9f9f9;
        }
        .gallery-thumbnails {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        .gallery-thumbnails img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border: 1px solid transparent;
            transition: 0.3s;
        }
        .gallery-thumbnails img.active {
            border-color: #000;
        }

        .detail-info .detail-brand {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: block;
        }
        .detail-name {
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .detail-stars {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 25px;
        }
        .star-icon.filled { fill: #000; }
        .reviews-count { font-size: 13px; color: #666; margin-left: 10px; }

        .detail-prices { margin-bottom: 30px; }
        .price-sale { font-size: 1.8rem; font-weight: 500; color: #000; }

        .detail-desc {
            font-size: 15px;
            line-height: 1.6;
            color: #444;
            margin-bottom: 40px;
            border-top: 1px solid #eee;
            padding-top: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #000;
            width: fit-content;
            margin-bottom: 30px;
        }
        .quantity-selector label { display: none; }
        .qty-btn {
            background: none;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 300;
        }
        .qty-value {
            width: 40px;
            text-align: center;
            font-weight: 600;
        }

        .size-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .size-option {
            border: 1px solid #ddd;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 13px;
            transition: 0.3s;
        }
        .size-option.active {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .detail-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 40px;
        }
        .btn-add-cart, .btn-buy-now {
            padding: 18px;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-add-cart { background: #000; color: #fff; border: 1px solid #000; }
        .btn-add-cart:hover { background: #333; }
        .btn-buy-now { background: #fff; color: #000; border: 1px solid #000; }
        .btn-buy-now:hover { background: #f5f5f5; }

        .detail-meta { border-top: 1px solid #eee; padding-top: 30px; font-size: 13px; }
        .detail-meta div { margin-bottom: 10px; display: flex; gap: 20px; }
        .detail-meta strong { width: 100px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }

        /* Black & White Product Card for Related Section */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }
        .product-card { border: none; transition: all 0.3s ease; position: relative; }
        .card-image { position: relative; overflow: hidden; background: #f9f9f9; }
        .card-image img { width: 100%; transition: transform 0.5s ease; }
        .product-card:hover img { transform: scale(1.05); }
        
        .add-to-cart-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #fff;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .product-card:hover .add-to-cart-btn { opacity: 1; transform: translateY(0); }
        
        .card-name a { font-weight: 600; text-transform: uppercase; font-size: 13px; color: #000; text-decoration: none; letter-spacing: 0.5px; }
        .price-sale { font-weight: 500; color: #000; font-size: 14px; }

        @media (max-width: 768px) {
            .detail-grid { grid-template-columns: 1fr; gap: 30px; }
            .detail-name { font-size: 1.8rem; }
        }
    </style>

    <!-- Product Detail -->
    <section class="product-detail container">
        <nav class="breadcrumb">
            <a href="{{ route('fe.home') }}">Trang chủ</a>
            <span class="sep">›</span>
            <span>{{ $product->name }}</span>
        </nav>

        <div class="detail-grid">
            <div class="detail-gallery">
                <img src="{{ $product->images ?? 'img/default.jpg' }}" alt="{{ $product->name }}" id="mainImage" />
                <div class="gallery-thumbnails">
                    <img src="{{ $product->images ?? 'img/default.jpg' }}" alt="{{ $product->name }}" class="active" />
                    {{-- Bạn có thể thêm vòng lặp ở đây nếu sản phẩm có nhiều ảnh --}}
                </div>
            </div>

            <div class="detail-info">
                <p class="detail-brand">Fashion Store</p>
                <h1 class="detail-name">{{ $product->name }}</h1>

                <div class="detail-stars">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="star-icon filled" viewBox="0 0 24 24" style="width:16px;height:16px">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    @endfor
                    <span class="reviews-count">(120 đánh giá)</span>
                </div>

                <div class="detail-prices">
                    <span class="price-sale">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                </div>

                <p class="detail-desc">{{ $product->description }}</p>

                <div class="mb-4">
                    <label class="form-label d-block mb-2" style="font-size: 11px; letter-spacing: 1px;">Chọn Size</label>
                    <div class="size-selector" id="sizeSelector">
                        @foreach($product->sizes ?? ['S', 'M', 'L', 'XL'] as $size)
                            <div class="size-option" data-size="{{ $size }}">{{ $size }}</div>
                        @endforeach
                    </div>
                </div>

                <div class="quantity-selector">
                    <label>Số lượng</label>
                    <button class="qty-btn" id="btn-minus">−</button>
                    <div class="qty-value" id="detailQty">1</div>
                    <button class="qty-btn" id="btn-plus">+</button>
                </div>

                <div class="detail-actions">
                    <button class="btn-add-cart" id="btn-add-to-cart-detail"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" 
                        data-price="{{ $product->price }}"
                        data-image="{{ $product->images ?? asset('img/default.jpg') }}">
                        <svg class="icon-sm" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <path d="M16 10a4 4 0 01-8 0" />
                        </svg>
                        Thêm vào giỏ
                    </button>
                    <button class="btn-buy-now" id="btn-buy-now"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" 
                        data-price="{{ $product->price }}"
                        data-image="{{ $product->images ?? asset('img/default.jpg') }}">
                        Mua ngay
                    </button>
                </div>

                <div class="detail-meta">
                    <div><strong>Tình trạng</strong><span style="color:#000; font-weight: 600;">Còn hàng</span></div>
                    <div><strong>Vận chuyển</strong><span>Miễn phí toàn quốc</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-section container" style="margin-top: 100px; border-top: 1px solid #eee; padding-top: 60px;">
        <h2 style="text-align: center; text-transform: uppercase; letter-spacing: 4px; font-weight: 300; margin-bottom: 50px;">Sản phẩm liên quan</h2>
        <div class="product-grid" style="padding-bottom:2rem">
            @foreach ($relatedProducts as $item)
                <article class="product-card">
                    <div class="card-image">
                        <a href="{{ route('fe.product.detail', $item->slug) }}">
                            <img src="{{ $item->images ?? asset('img/default.jpg') }}" alt="{{ $item->name }}" loading="lazy" />
                        </a>
                        <button class="add-to-cart-btn btn-add-to-cart" style="margin-bottom: 15px"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}" 
                            data-price="{{ $item->price }}"
                            data-image="{{ $item->images ?? asset('img/default.jpg') }}">
                            <svg style="width:16px; height:16px" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                    <div class="card-info">
                        <h3 class="card-name">
                            <a href="{{ route('fe.product.detail', $item->slug) }}">{{ $item->name }}</a>
                        </h3>
                        <div class="card-prices">
                            <span class="price-sale">{{ number_format($item->price, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Chọn size
            $('.size-option').on('click', function() {
                $('.size-option').removeClass('active');
                $(this).addClass('active');
            });

            // Thay đổi ảnh sản phẩm (Gallery) dùng jQuery
            $('.gallery-thumbnails img').on('click', function() {
                const src = $(this).attr('src');
                $('#mainImage').attr('src', src);
                $('.gallery-thumbnails img').removeClass('active');
                $(this).addClass('active');
            });

            // Xử lý tăng giảm số lượng tại trang chi tiết
            $('#btn-plus').on('click', function() {
                let val = parseInt($('#detailQty').text());
                $('#detailQty').text(val + 1);
            });

            $('#btn-minus').on('click', function() {
                let val = parseInt($('#detailQty').text());
                if (val > 1) $('#detailQty').text(val - 1);
            });

            // Thêm vào giỏ hàng tại trang chi tiết
            $('#btn-add-to-cart-detail').on('click', function() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const selectedSize = $('.size-option.active').data('size');
                
                if (!selectedSize) {
                    alert('Vui lòng chọn size!');
                    return;
                }

                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');
                const qty = parseInt($('#detailQty').text());

                const existingItem = cart.find(item => item.id == id && item.size == selectedSize);
                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    cart.push({ id, name, price, image, qty, size: selectedSize });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                toggleCart(); // Tự động mở giỏ hàng khi thêm thành công
            });

            // Xử lý nút Mua ngay: Thêm vào giỏ rồi chuyển hướng
            $('#btn-buy-now').on('click', function() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const selectedSize = $('.size-option.active').data('size');
                
                if (!selectedSize) {
                    alert('Vui lòng chọn size!');
                    return;
                }

                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');
                const qty = parseInt($('#detailQty').text());

                const existingItem = cart.find(item => item.id == id && item.size == selectedSize);
                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    cart.push({ id, name, price, image, qty, size: selectedSize });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                window.location.href = "{{ route('fe.checkout') }}";
            });

            // Thêm vào giỏ hàng cho các sản phẩm liên quan
            $(document).on('click', '.btn-add-to-cart', function() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');

                const existingItem = cart.find(item => item.id == id && !item.size);
                if (existingItem) {
                    existingItem.qty += 1;
                } else {
                    cart.push({ id, name, price, image, qty: 1, size: null });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                toggleCart();
            });
        });
    </script>
@endpush
