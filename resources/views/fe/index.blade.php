@extends('fe.layouts.home')
@section('page_title')
    Trang Chủ
@endsection
@section('content')
    <style>
        .hero-slider { margin-bottom: 50px; }
        .hero-slide-item { position: relative; height: 80vh; overflow: hidden; display: flex; align-items: center; }
        .hero-slide-item img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
        .hero-slider__copy {
            position: relative;
            z-index: 10; /* Tăng z-index để nổi lên trên lớp phủ overlay */
            color: #fff;
            text-align: left;
        }
        .hero-slider__copy h1 {
            font-size: 4rem;
            font-weight: 800;
            text-transform: uppercase;
            margin: 10px 0;
            text-shadow: 0 0 10px rgba(0,0,0,0.5); /* Thêm đổ bóng cho tiêu đề chính */
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
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        .btn-hero:hover {
            background: #000;
            color: #fff;
            transform: translateY(-3px);
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

        /* Search Box & View All Button */
        .search-box { position: relative; }
        .search-box input {
            border: none;
            border-bottom: 2px solid #eee;
            border-radius: 0;
            padding: 8px 35px 8px 0;
            font-size: 14px;
            transition: border-color 0.3s;
            width: 200px;
            background: transparent;
        }
        .search-box input:focus {
            outline: none;
            border-bottom-color: #000;
            box-shadow: none;
        }
        .search-box i { position: absolute; right: 5px; top: 50%; transform: translateY(-50%); color: #757575; }

        .btn-view-all {
            display: inline-block;
            padding: 12px 40px;
            border: 2px solid #000;
            color: #000;
            font-weight: 700;
            text-transform: uppercase;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-view-all:hover { background: #000; color: #fff; }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-slide-item { height: 60vh; }
            .hero-slider__copy {
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
        <div class="filters d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div class="filter-chips d-flex align-items-center">
                <a href="{{ route('fe.home', request()->except(['category', 'page'])) }}" 
                   class="chip {{ !request('category') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">Tất cả</a>
                @foreach($categories as $cat)
                    <a href="{{ route('fe.home', array_merge(request()->query(), ['category' => $cat->id])) }}" 
                       class="chip {{ request('category') == $cat->id ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            
            <div class="d-flex align-items-center gap-4 flex-wrap mt-3 mt-md-0">
                <form action="{{ route('fe.home') }}" method="GET" class="search-box">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit" style="background:none; border:none; position: absolute; right: 5px; top: 50%; transform: translateY(-50%); color: #757575;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <select class="sort-select" onchange="applySort(this.value)">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                    <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                    <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                    <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Tên: A → Z</option>
                </select>
                <p class="product-count mb-0" id="productCount">{{ $products->total() }} sản phẩm</p>
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

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
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
