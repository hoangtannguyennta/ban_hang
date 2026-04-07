@extends('fe.layouts.home')

@section('page_title')
    {{ $product->name }}
@endsection

@section('content')
    <!-- Product Detail -->
    <section class="product-detail container">
        <nav class="breadcrumb">
            <a href="{{ route('fe.home') }}">Trang chủ</a>
            <span class="sep">›</span>
            <span>{{ $product->name }}</span>
        </nav>

        <div class="detail-grid">
            <div class="detail-gallery">
                <img src="{{ asset('storage/' . ($product->image ?? 'img/default.jpg')) }}" alt="{{ $product->name }}" id="mainImage" />
                <div class="gallery-thumbnails">
                    <img src="{{ asset('storage/' . ($product->image ?? 'img/default.jpg')) }}" alt="{{ $product->name }}" class="active" onclick="changeImage(this)" />
                    {{-- Bạn có thể thêm vòng lặp ở đây nếu sản phẩm có nhiều ảnh --}}
                </div>
            </div>

            <div class="detail-info">
                <p class="detail-brand" style="color: var(--gold); font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 0.75rem;">Fashion Store</p>
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

                <p class="detail-desc">{{ $product->desc }}</p>

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
                        data-image="{{ asset('storage/' . ($product->image ?? 'img/default.jpg')) }}">
                        <svg class="icon-sm" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <path d="M16 10a4 4 0 01-8 0" />
                        </svg>
                        Thêm vào giỏ
                    </button>
                    <button class="btn-buy-now">Mua ngay</button>
                </div>

                <div class="detail-meta">
                    <div><strong>Tình trạng</strong><span style="color:var(--gold)">Còn hàng</span></div>
                    <div><strong>Vận chuyển</strong><span>Miễn phí toàn quốc</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-section container">
        <h2><span class="text-gold-gradient">Sản phẩm liên quan</span></h2>
        <div class="product-grid" style="padding-bottom:2rem">
            @foreach ($relatedProducts as $item)
                <article class="product-card">
                    <div class="card-image">
                        <a href="{{ route('fe.product.detail', $item->slug) }}">
                            <img src="{{ asset('storage/' . ($item->image ?? 'img/default.jpg')) }}" alt="{{ $item->name }}" loading="lazy" />
                        </a>
                        <div class="card-image-overlay"></div>
                        <button class="add-to-cart-btn btn-add-to-cart" 
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}" 
                            data-price="{{ $item->price }}"
                            data-image="{{ asset('storage/' . ($item->image ?? 'img/default.jpg')) }}">
                            <svg class="icon-sm" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                    <div class="card-info">
                        <p class="card-brand" style="color: var(--fg-muted); font-size: 0.6rem; letter-spacing: 0.15em; text-transform: uppercase;">Brand Name</p>
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
        function changeImage(el) {
            document.getElementById('mainImage').src = el.src;
            document.querySelectorAll('.gallery-thumbnails img').forEach(i => i.classList.remove('active'));
            el.classList.add('active');
        }

        $(document).ready(function() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            function updateCartUI() {
                localStorage.setItem('cart', JSON.stringify(cart));
                const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
                $('.cart-badge').text(totalQty);
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

            $('#btn-plus').click(function() {
                let val = parseInt($('#detailQty').text());
                $('#detailQty').text(val + 1);
            });
            $('#btn-minus').click(function() {
                let val = parseInt($('#detailQty').text());
                if (val > 1) $('#detailQty').text(val - 1);
            });

            $('#btn-add-to-cart-detail').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');
                const qty = parseInt($('#detailQty').text());

                const existingItem = cart.find(item => item.id == id);
                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    cart.push({ id, name, price, image, qty });
                }
                updateCartUI();
                $('.cart-sidebar, .cart-overlay').addClass('open');
            });

            $(document).on('click', '.btn-add-to-cart', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');

                const existingItem = cart.find(item => item.id == id);
                if (existingItem) {
                    existingItem.qty += 1;
                } else {
                    cart.push({ id, name, price, image, qty: 1 });
                }
                updateCartUI();
                $('.cart-sidebar, .cart-overlay').addClass('open');
            });

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

            $(document).on('click', '.cart-remove', function() {
                const id = $(this).data('id');
                cart = cart.filter(c => c.id != id);
                updateCartUI();
            });

            updateCartUI();
        });
    </script>
@endpush
