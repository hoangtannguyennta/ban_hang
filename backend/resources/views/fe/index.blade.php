@extends('fe.layouts.home')
@section('page_title')
    Trang Chủ
@endsection
@section('content')
    <!-- Hero Slider -->
    <section class="hero-slider">
        <div class="hero-slider__wrapper">
            <div class="banner-slider">
                @foreach ($slides as $slide)
                    <div class="hero-slide-item">
                        <img src="{{ asset('storage/' . $slide->images) }}" alt="{{ $slide->title }}">
                        <div class="container hero-slider__copy">
                            @if ($slide->subtitle)
                                <p class="hero-label">{{ $slide->subtitle }}</p>
                            @endif
                            <h1><span class="text-gold-gradient">{{ $slide->title }}</span></h1>
                            <p class="hero-desc">{{ $slide->desc }}</p>
                            <a href="{{ $slide->link ?? '#' }}" class="btn-hero">Khám phá ngay</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main -->
    <main class="container">
        <!-- Filters -->
        <div class="filters">
            <div class="filter-chips">
                <button class="chip active" onclick="filterBrand('')">Tất cả</button>
                <button class="chip" onclick="filterBrand('Nike')">Nike</button>
                <button class="chip" onclick="filterBrand('Adidas')">Adidas</button>
                <button class="chip" onclick="filterBrand('Uniqlo')">Uniqlo</button>
            </div>
            <select class="sort-select" onchange="sortProducts(this.value)">
                <option value="featured">Nổi bật</option>
                <option value="price-asc">Giá thấp đến cao</option>
                <option value="price-desc">Giá cao đến thấp</option>
                <option value="name-asc">Tên: A → Z</option>
            </select>
            <p class="product-count" id="productCount">8 sản phẩm</p>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            @foreach ($products as $product)
                <article class="product-card">
                    <div class="card-image">
                        <a href="{{ route('fe.product.detail', $product->slug) }}">
                            <img src="{{ asset('storage/' . ($product->image ?? 'img/default.jpg')) }}"
                                alt="{{ $product->name }}" loading="lazy" />
                        </a>
                        <div class="card-image-overlay"></div>
                        @if ($product->price < 1000000)
                            {{-- Ví dụ logic tag sale --}}
                            <span class="badge-sale" style="background: #ff4757;">SALE</span>
                        @endif
                        <button class="add-to-cart-btn btn-add-to-cart" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                            data-image="{{ asset('storage/' . ($product->image ?? 'img/default.jpg')) }}">
                            <svg class="icon-sm" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                    <div class="card-info">
                        <div class="stars">
                            {{-- Render sao tĩnh hoặc logic từ review --}}
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="star-icon filled" viewBox="0 0 24 24">
                                    <polygon
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            @endfor
                        </div>
                        <p class="card-brand" style="color: var(--text-muted); font-size: 0.85rem;">Brand Name</p>
                        <h3 class="card-name">
                            <a href="{{ route('fe.product.detail', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="card-prices">
                            <span class="price-sale">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Khởi tạo giỏ hàng từ localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Hàm cập nhật giao diện giỏ hàng
            function updateCartUI() {
                localStorage.setItem('cart', JSON.stringify(cart));

                // Cập nhật số lượng trên Badge
                const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
                $('.cart-badge').text(totalQty);

                // Cập nhật danh sách trong Sidebar
                const $cartList = $('.cart-items');
                if ($cartList.length) {
                    $cartList.empty();
                    let totalAmount = 0;

                    if (cart.length === 0) {
                        $cartList.html('<div class="cart-empty">Giỏ hàng của bạn đang trống.</div>');
                    } else {
                        cart.forEach(item => {
                            totalAmount += item.price * item.qty;
                            $cartList.append(`
                <div class="cart-item">
                  <img src="${item.image}" alt="${item.name}">
                  <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${new Intl.NumberFormat('vi-VN').format(item.price)}₫</div>
                    <div class="cart-item-qty">
                      <button class="btn-qty" data-id="${item.id}" data-delta="-1">-</button>
                      <span>${item.qty}</span>
                      <button class="btn-qty" data-id="${item.id}" data-delta="1">+</button>
                    </div>
                    <button class="cart-remove" data-id="${item.id}">Xóa</button>
                  </div>
                </div>
              `);
                        });
                    }
                    $('.total-price').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + '₫');
                }
            }

            // Xử lý thêm vào giỏ
            $(document).on('click', '.btn-add-to-cart', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');

                const existingItem = cart.find(item => item.id == id);
                if (existingItem) {
                    existingItem.qty += 1;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        image,
                        qty: 1
                    });
                }

                updateCartUI();
                $('.cart-sidebar, .cart-overlay').addClass('open'); // Mở sidebar để thông báo
            });

            // Tăng giảm số lượng
            $(document).on('click', '.btn-qty', function() {
                const id = $(this).data('id');
                const delta = parseInt($(this).data('delta'));
                const item = cart.find(c => c.id == id);
                if (item) {
                    item.qty += delta;
                    if (item.qty <= 0) cart = cart.filter(c => c.id != id);
                    updateCartUI();
                }
            });

            // Xóa sản phẩm
            $(document).on('click', '.cart-remove', function() {
                const id = $(this).data('id');
                cart = cart.filter(c => c.id != id);
                updateCartUI();
            });

            // Khởi tạo UI ban đầu
            updateCartUI();

            // Khởi tạo Slick Slider
            $('.banner-slider').slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                arrows: true,
                infinite: true
            });
        });
    </script>
@endpush
