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

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* --- Modern Product Grid --- */
        .product-card {
            border: none;
            background: transparent;
            transition: var(--transition-smooth);
            padding-bottom: 10px;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .card-image {
            position: relative;
            overflow: hidden;
            background: #fcfcfc;
            aspect-ratio: 3/4;
            width: 100%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.5s ease;
            backface-visibility: hidden;
        }
        .product-card:hover .main-img {
            transform: scale(1.05);
            transition: transform 0.8s ease;
        }
        .card-image .hover-img {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            z-index: 1;
        }
        .product-card:hover .hover-img {
            opacity: 1;
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
            border-bottom: 1px solid #eee;
            border-radius: 0;
            padding: 8px 30px 8px 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 120px;
            background: transparent;
            transition: all 0.4s ease;
        }
        .search-box input:focus {
            outline: none;
            border-bottom-color: #000;
            width: 180px;
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
            padding: 5px 0;
            border-bottom: 1px solid transparent;
            transition: border-bottom-color 0.3s;
        }
        .sort-select:hover {
            border-bottom-color: #000;
        }

        /* --- Hover Actions Style --- */
        .product-card-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            transform: translateY(100%);
            transition: all 0.4s ease;
            opacity: 0;
            z-index: 5;
        }
        .product-card:hover .product-card-actions {
            transform: translateY(0);
            opacity: 1;
        }
        .p-action-btn {
            border: none;
            padding: 12px;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.3s;
        }
        .p-action-btn.view { background: rgba(255,255,255,0.9); color: #000; }
        .p-action-btn.add { background: #000; color: #fff; }

        @media (min-width: 992px) {
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

        /* --- Hot Collection Section --- */
        .collection-section {
            padding: 100px 0;
            background: #fff;
        }
        .collection-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .collection-header h2 {
            font-size: 2.5rem;
            font-weight: 300;
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .collection-header p {
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #888;
        }
        .collection-card {
            position: relative;
            margin-bottom: 30px;
            transition: var(--transition-smooth);
        }
        .collection-card:hover {
            transform: scale(1.02);
        }
        .collection-card img {
            width: 100%;
            aspect-ratio: 4/5;
            object-fit: cover;
        }

        /* --- Newsletter Section --- */
        .newsletter-section {
            background: #000;
            color: #fff;
            padding: 80px 0;
            text-align: center;
            margin-top: 80px;
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
            .filter-links {
                overflow-x: auto;
                white-space: nowrap;
                width: calc(100% + 30px);
                margin-left: -15px;
                padding-left: 15px;
                padding-bottom: 10px;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }
            .filter-links::-webkit-scrollbar { display: none; }
            
            .product-card-actions {
                opacity: 1;
                transform: translateY(0);
            }
            .p-action-btn {
                padding: 10px;
                font-size: 8px;
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

    <!-- Hot Collection Section -->
    <section class="collection-section">
        <div class="container">
            <div class="collection-header">
                <p>Hot Trends {{ now()->format('Y') }}</p>
                <h2>Bộ sưu tập mới</h2>
                <div style="width: 50px; height: 1px; background: #000; margin: 20px auto;"></div>
            </div>
            <div class="row">
                @foreach($hotProducts as $item)
                    <div class="col-md-4">
                        <div class="collection-card">
                            <a href="{{ route('fe.product.detail', $item->slug) }}">
                                <img src="{{ $item->images ?? asset('img/default.jpg') }}" alt="{{ $item->name }}">
                                <div style="margin-top: 15px; text-align: center;">
                                    <h4 style="font-size: 13px; letter-spacing: 2px; text-transform: uppercase; color: #000;">{{ $item->name }}</h4>
                                    <p style="font-size: 12px; font-weight: 600;">{{ number_format($item->price, 0, ',', '.') }}₫</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <main class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 style="font-size: 1.5rem; font-weight: 300; letter-spacing: 6px; text-transform: uppercase; color: #000; margin-bottom: 10px;">New Arrivals</h2>
            <p style="font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #888;">Cập nhật xu hướng mỗi ngày cùng Nhà Bi</p>
        </div>

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            @foreach ($products as $product)
                <article class="product-card">
                    <div class="card-image">
                        <a href="{{ route('fe.product.detail', $product->slug) }}">
                            <img src="{{ $product->images ?? asset('img/default.jpg') }}" 
                                 class="main-img" alt="{{ $product->name }}" loading="lazy" />
                            <img src="{{ $product->hover_image ?? ($product->images ?? asset('img/default.jpg')) }}" 
                                 class="hover-img" alt="{{ $product->name }}" loading="lazy" />
                        </a>
                        @if ($product->price < 1000000)
                            <span class="badge-sale" style="background: #ff4757;">SALE</span>
                        @endif
                        <div class="product-card-actions">
                            <a href="{{ route('fe.product.detail', $product->slug) }}" class="p-action-btn view">Xem chi tiết</a>
                            <button class="p-action-btn add btn-add-to-cart" 
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" 
                                data-price="{{ $product->price }}"
                                data-image="{{ $product->images ?? asset('img/default.jpg') }}"
                                data-sizes="{{ json_encode($product->sizes) }}">
                                Thêm vào giỏ
                            </button>
                        </div>
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
        <div class="custom-pagination mt-5">
            {{ $products->links() }}
        </div>

        <!-- View All / Reset Button -->
        <div class="text-center mt-4 mb-5">
            <a href="{{ route('fe.products.all') }}" class="btn-view-all">Xem tất cả sản phẩm</a>
        </div>

        <!-- Newsletter -->
        <section class="newsletter-section">
            <div class="container">
                <h2 style="letter-spacing: 5px; font-weight: 300; text-transform: uppercase; margin-bottom: 20px;">Tham gia cùng Nhà Bi</h2>
                <p style="color: #ccc; font-size: 13px; letter-spacing: 1px; margin-bottom: 40px;">Nhận thông báo về bộ sưu tập mới và các ưu đãi đặc quyền sớm nhất.</p>
                <div class="d-flex justify-content-center">
                    <input type="email" placeholder="ĐỊA CHỈ EMAIL CỦA BẠN" style="background: transparent; border: none; border-bottom: 1px solid #555; color: #fff; padding: 10px; width: 300px; font-size: 11px; outline: none;">
                    <button class="btn-hero" style="margin-top: 0; padding: 10px 30px; border-color: #fff;">Đăng ký</button>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        // Khởi tạo Slick Slider
        $('.banner-slider').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            dots: true,
            arrows: true,
            infinite: true
        });
    </script>
@endpush
