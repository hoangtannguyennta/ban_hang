@extends('fe.layouts.home')
@section('page_title')
    Trang Chủ
@endsection
@section('content')
    <style>
        .hero-slider { margin-bottom: 50px; }
        .hero-slide-item { position: relative; height: 80vh; overflow: hidden; }
        .hero-slide-item img { width: 100%; height: 100%; object-fit: cover; }
        .hero-slider__copy {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            color: #fff;
            text-align: left;
        }
        .hero-slider__copy h1 {
            font-size: 4rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 10px 0;
            line-height: 1;
        }
        .hero-slider__copy h1 span {
            background: none !important;
            -webkit-text-fill-color: initial !important;
            color: #fff;
        }
        .btn-hero {
            background: #fff;
            color: #000;
            padding: 12px 30px;
            text-transform: uppercase;
            font-weight: 700;
            border-radius: 0;
            display: inline-block;
            margin-top: 20px;
        }
        .filter-chips .chip {
            border: none;
            background: transparent;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 13px;
            padding: 5px 0;
            margin-right: 25px;
            border-bottom: 2px solid transparent;
        }
        .filter-chips .chip.active {
            border-bottom: 2px solid #000;
            background: transparent;
            color: #000;
        }
        .product-card { border: none; transition: all 0.3s ease; }
        .card-name a { font-weight: 600; text-transform: uppercase; font-size: 14px; color: #000; }
        .price-sale { font-weight: 500; color: #666; font-size: 13px; }
        .add-to-cart-btn {
            background: #000;
            border-radius: 0;
            opacity: 0;
            transition: 0.3s;
        }
        .product-card:hover .add-to-cart-btn { opacity: 1; }
        .badge-sale { border-radius: 0; font-size: 10px; font-weight: 700; padding: 4px 10px; }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-slide-item { height: 60vh; }
            .hero-slider__copy {
                top: unset;
                left: 5%;
                right: 5%;
                text-align: center;
            }
            .hero-slider__copy h1 {
                font-size: 2.2rem;
            }
            .hero-desc {
                font-size: 0.9rem;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .filters {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            .filter-chips {
                overflow-x: auto;
                white-space: nowrap;
                width: 100%;
                padding-bottom: 10px;
            }
        }
    </style>
    <!-- Hero Slider -->
    <section class="hero-slider">
        <div class="hero-slider__wrapper">
            <div class="banner-slider">
                @foreach ($slides as $slide)
                    <div class="hero-slide-item">
                        <img src="{{ $slide->images }}" alt="{{ $slide->title }}">
                        <div class="container hero-slider__copy">
                            @if ($slide->subtitle)
                                <p class="hero-label">{{ $slide->subtitle }}</p>
                            @endif
                            <h1><span>{{ $slide->title }}</span></h1>
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
                            <img src="{{ $product->images ?? asset('img/default.jpg') }}"
                                alt="{{ $product->name }}" loading="lazy" />
                        </a>
                        <div class="card-image-overlay"></div>
                        @if ($product->price < 1000000)
                            {{-- Ví dụ logic tag sale --}}
                            <span class="badge-sale" style="background: #ff4757;">SALE</span>
                        @endif
                        <button class="add-to-cart-btn btn-add-to-cart" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                            data-image="{{ $product->images ?? asset('img/default.jpg') }}">
                            <svg class="icon-sm" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                            Thêm vào giỏ
                        </button>
                    </div>
                    <div class="card-info">
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
            // Xử lý thêm vào giỏ
            $(document).on('click', '.btn-add-to-cart', function() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
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

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                toggleCart();
            });

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
