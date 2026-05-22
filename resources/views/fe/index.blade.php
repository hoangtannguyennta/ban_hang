@extends('fe.layouts.home')
@section('page_title')
    Trang Chủ
@endsection
@section('content')
    <style>
        :root {
            --text-muted: #757575;
            --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* --- Minimalist Filters Custom --- */
        .filters {
            margin-bottom: 50px !important;
            padding: 10px 0;
        }
        .filter-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #aaa;
            font-weight: 800;
            margin-right: 20px;
        }
        .filter-chips .chip {
            display: inline-block;
            background: #f8f8f8;
            color: #888;
            padding: 8px 18px;
            margin-right: 8px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
        .filter-chips .chip.active {
            background: #000;
            color: #fff;
            border-color: #000;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .filter-chips .chip:hover:not(.active) {
            background: #fff;
            color: #000;
            border-color: #000;
        }

        /* --- Modern Product Grid --- */
        .product-card {
            border: none;
            background: transparent;
            transition: var(--transition-smooth);
        }
        .card-image {
            position: relative;
            overflow: hidden;
            background: #fcfcfc;
            aspect-ratio: 3/4;
            width: 100%;
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .product-card:hover .card-image img {
            transform: scale(1.08);
        }
        .card-info {
            padding: 20px 0;
            text-align: left;
        }
        .card-name a {
            font-family: var(--font-heading);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            color: #000;
            letter-spacing: 1px;
        }
        .price-sale {
            font-weight: 600;
            color: #000;
            font-size: 13px;
            letter-spacing: 1px;
        }

        /* --- Search & Sort Styles --- */
        .search-box {
            position: relative;
        }
        .search-box input {
            border: none;
            border-bottom: 1px solid #ddd;
            border-radius: 0;
            padding: 8px 30px 8px 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 150px;
            background: transparent;
            transition: border-color 0.3s;
        }
        .search-box input:focus {
            outline: none;
            border-bottom-color: #000;
        }
        
        .sort-select {
            border: none;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            background: transparent;
            cursor: pointer;
            color: #000;
            outline: none;
        }

        /* --- Hover Button Effect --- */
        .add-to-cart-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #fff;
            border-radius: 0 !important;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            opacity: 0;
            transform: translateY(100%);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            z-index: 3;
        }
        
        @media (min-width: 992px) {
            .product-card:hover .add-to-cart-btn {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px 10px;
            width: 100%;
        }

        @media (min-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 40px 20px;
            }
        }
        
        .badge-sale {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            border-radius: 0;
            font-size: 9px;
            font-weight: 700;
            padding: 5px 12px;
            letter-spacing: 1px;
        }

        .product-count {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #bbb;
        }

        /* --- Hero Slider Styles --- */
        .hero-slider { 
            margin-bottom: 60px; 
            overflow: hidden; 
            width: 100%;
        }
        .hero-slide-item { 
            position: relative; 
            height: 80vh; 
            display: flex; 
            align-items: center; 
            background: #000;
        }
        .hero-slide-item img { 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            opacity: 0.6;
        }
        .hero-slider__copy { 
            position: relative; 
            z-index: 10; 
            color: #fff; 
            width: 100%;
        }
        .hero-label { font-size: 11px; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 15px; }
        .hero-slider__copy h1 { font-size: 3.5rem; font-weight: 300; text-transform: uppercase; margin: 10px 0; letter-spacing: 8px; line-height: 1.1; }
        .btn-hero {
            background: transparent;
            color: #fff;
            border: 1px solid #fff;
            padding: 15px 40px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 3px;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            transition: var(--transition-smooth);
            cursor: pointer;
        }
        .btn-hero:hover { background: #fff; color: #000; }

        .btn-view-all {
            display: inline-block;
            padding: 15px 50px;
            border: 1px solid #000;
            color: #000;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 2px;
            transition: var(--transition-smooth);
            text-decoration: none;
        }
        .btn-view-all:hover {
            background: #000;
            color: #fff;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-slide-item {
                height: 50vh !important;
                min-height: 400px;
                width: 100%;
            }
            .hero-slider__copy {
                text-align: left;
                padding: 0 20px;
            }
            .hero-slider__copy h1 {
                font-size: 1.8rem;
                letter-spacing: 4px;
            }
            .hero-desc {
                font-size: 13px;
                line-height: 1.4;
                margin-bottom: 20px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .filters {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
                margin-bottom: 30px !important;
            }
            .filter-chips {
                overflow-x: auto;
                white-space: nowrap;
                width: calc(100% + 30px);
                margin-left: -15px;
                padding-left: 15px;
                padding-bottom: 10px;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }
            .filter-chips::-webkit-scrollbar { display: none; }
            
            .add-to-cart-btn {
                opacity: 1;
                transform: translateY(0);
                padding: 10px;
                font-size: 9px;
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
        <div class="filters d-flex justify-content-between align-items-end flex-wrap mb-4">
            <div class="d-flex align-items-center">
                <span class="filter-label d-none d-md-inline-block">Bộ lọc:</span>
                <div class="filter-chips d-flex align-items-center">
                    <a href="{{ route('fe.home', request()->except(['category', 'page'])) }}" 
                       class="chip {{ !request('category') ? 'active' : '' }}">Tất cả</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('fe.home', array_merge(request()->query(), ['category' => $cat->id])) }}" 
                           class="chip {{ request('category') == $cat->id ? 'active' : '' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-4 flex-wrap mt-4 mt-md-0">
                <p class="product-count mb-0 d-none d-lg-block" id="productCount">{{ $products->total() }} sản phẩm</p>
                
                <form action="{{ route('fe.home') }}" method="GET" class="search-box">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="TÌM KIẾM...">
                    <button type="submit" style="background:none; border:none; position: absolute; right: 5px; top: 50%; transform: translateY(-50%); color: #757575;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <select class="sort-select" onchange="applySort(this.value)">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Mặc định</option>
                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá: Thấp - Cao</option>
                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá: Cao - Thấp</option>
                    <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Tên: A - Z</option>
                </select>
            </div>
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
                        @if ($product->price < 1000000)
                            <span class="badge-sale" style="background: #ff4757;">SALE</span>
                        @endif
                        <button class="add-to-cart-btn btn-add-to-cart" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                            data-image="{{ $product->images ?? asset('img/default.jpg') }}">
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
                            <a href="{{ route('fe.product.detail', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="card-prices">
                            <span class="price-sale">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="custom-pagination">
            {{ $products->links() }}
        </div>

        <!-- View All / Reset Button -->
        <div class="text-center mt-4 mb-5">
            <a href="{{ route('fe.products.all') }}" class="btn-view-all">Xem tất cả sản phẩm</a>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        function applySort(sortValue) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortValue);
            // Reset trang về 1 khi đổi cách sắp xếp (nếu có phân trang)
            if (url.searchParams.has('page')) url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        $(document).ready(function() {
            // Xử lý thêm vào giỏ
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
