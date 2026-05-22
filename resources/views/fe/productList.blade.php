@extends('fe.layouts.home')

@section('page_title')
    Danh mục: {{ $category->name }}
@endsection

@section('content')
    <style>
        :root {
            --primary-black: #1a1a1a;
            --text-muted: #757575;
            --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .category-header {
            padding: 60px 0;
            background: #fcfcfc;
            margin-bottom: 40px;
            border-bottom: 1px solid #f0f0f0;
        }

        .category-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .category-header h1 {
            font-size: 2.2rem;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 0;
            color: var(--primary-black);
            flex: 1;
            text-align: center;
        }

        .category-header .product-count-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--text-muted);
            opacity: 0.8;
            flex: 1;
            text-align: right;
        }

        /* Breadcrumb styling */
        .breadcrumb-container {
            display: flex;
            flex: 1;
            margin-bottom: 0;
        }
        .breadcrumb-list {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .breadcrumb-list a { color: var(--text-muted); text-decoration: none; transition: color 0.3s; }
        .breadcrumb-list a:hover { color: #000; }
        .breadcrumb-list .sep { font-size: 8px; opacity: 0.5; }
        .breadcrumb-list .current { color: #000; font-weight: 700; }

        /* --- Modern Product Grid --- */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 40px 20px;
        }

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
            padding: 15px 0;
            text-align: left;
        }

        .card-name a {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 13px;
            color: var(--primary-black);
            text-decoration: none;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 5px;
        }

        .price-sale {
            font-weight: 700;
            color: var(--primary-black);
            font-size: 14px;
        }

        /* --- Hover Button Effect --- */
        .add-to-cart-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #fff;
            border-radius: 0;
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
        }

        .product-card:hover .add-to-cart-btn {
            opacity: 1;
            transform: translateY(0);
        }

        /* Pagination styling */
        .pagination {
            gap: 10px;
        }
        .page-link {
            border: none;
            color: var(--primary-black);
            font-weight: 600;
            padding: 10px 18px;
        }
        .page-item.active .page-link {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
        }
        
        /* Sidebar Filter Style */
        .filter-sidebar {
            border-right: 1px solid #eee;
            padding-right: 30px;
        }
        .filter-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary-black);
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 5px;
        }
        .price-input-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .price-input-group input {
            border: 1px solid #eee;
            padding: 10px;
            font-size: 12px;
            border-radius: 0;
            width: 100%;
        }
        .btn-filter {
            background: #000;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: var(--transition-smooth);
        }
        .btn-filter:hover { background: #333; }

        /* New/Updated styles for form controls in sidebar */
        .filter-sidebar .form-control {
            font-size: 12px;
            border-radius: 0;
            border: 1px solid #eee;
            padding: 8px 12px; /* Adjust padding for better look */
            width: 100%;
            transition: border-color 0.3s ease;
        }
        .filter-sidebar .form-control:focus {
            border-color: var(--primary-black);
            box-shadow: none;
            outline: none;
        }

        /* Search Box specific styles */
        .filter-sidebar .search-box {
            position: relative;
        }
        .filter-sidebar .search-box input {
            padding-right: 35px; /* Make space for the icon */
        }
        .filter-sidebar .search-box .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none; /* So clicks pass through to the input */
        }

        /* Sort Select specific styles */
        .filter-sidebar select.form-control {
            cursor: pointer;
            appearance: none; /* Remove default arrow */
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
        .filter-sidebar select.form-control:hover {
            border-color: var(--primary-black);
        }

        /* Custom Radio Buttons cho Khoảng giá */
        .filter-radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 12px;
            color: var(--text-muted);
            padding: 8px 0;
            transition: var(--transition-smooth);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .filter-radio-label input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin-right: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .filter-radio-label input[type="radio"]:checked {
            border: 5px solid var(--primary-black);
        }
        .filter-radio-label:hover, .filter-radio-label:has(input:checked) {
            color: var(--primary-black);
            font-weight: 700;
        }

        /* Clear filters link */
        .clear-filters-link {
            color: var(--text-muted) !important;
            text-decoration: none !important;
            transition: color 0.3s ease;
        }
        .clear-filters-link:hover {
            color: var(--primary-black) !important;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .filter-sidebar {
                border-right: none;
                border-bottom: 1px solid #eee;
                padding-right: 0;
                padding-bottom: 30px;
                margin-bottom: 30px;
            }
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px 10px;
            }
            .category-header h1 { font-size: 1.5rem; order: 1; margin-bottom: 15px; }
            .category-header .container {
                flex-direction: column;
                text-align: center;
            }
            .breadcrumb-container { order: 2; margin-bottom: 10px; justify-content: center; }
            .product-count-label { order: 3; text-align: center; }
        }
    </style>

    <header class="category-header">
        <div class="container">
            <nav class="breadcrumb-container">
                <ul class="breadcrumb-list">
                    <li><a href="{{ route('fe.home') }}">Trang chủ</a></li>
                    <li class="sep">/</li>
                    <li class="current">{{ $category->name }}</li>
                </ul>
            </nav>
            <h1>{{ $category->name }}</h1>
            <div class="product-count-label">{{ $products->total() }} sản phẩm</div>
        </div>
    </header>

    <main class="container mb-5">
        <div class="row">
            <!-- Sidebar bên trái -->
            <aside class="col-lg-3 filter-sidebar">
                <form action="{{ route('fe.category', $category->id) }}" method="GET" id="filterForm">
                    <!-- Lọc theo giá (Đưa lên đầu) -->
                    <div class="mb-5">
                        <h3 class="filter-title">Khoảng giá</h3>
                        <div class="price-ranges d-flex flex-column"> <!-- Removed gap-2 -->
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="" {{ !request('min_price') && !request('max_price') ? 'checked' : '' }} onclick="setPriceRange('', '')">
                                Tất cả
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="0-500" {{ request('max_price') == 500000 ? 'checked' : '' }} onclick="setPriceRange('', 500000)">
                                Dưới 500.000₫
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="500-1000" {{ request('min_price') == 500000 && request('max_price') == 1000000 ? 'checked' : '' }} onclick="setPriceRange(500000, 1000000)">
                                500.000₫ - 1.000.000₫
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="1000-2000" {{ request('min_price') == 1000000 && request('max_price') == 2000000 ? 'checked' : '' }} onclick="setPriceRange(1000000, 2000000)">
                                1.000.000₫ - 2.000.000₫
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="2000+" {{ request('min_price') == 2000000 ? 'checked' : '' }} onclick="setPriceRange(2000000, '')">
                                Trên 2.000.000₫
                            </label>
                        </div>
                        
                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                    </div>

                    <!-- Tìm kiếm theo tên -->
                    <div class="mb-5">
                        <h3 class="filter-title">Tìm kiếm</h3>
                        <div class="search-box"> <!-- Removed inline style -->
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên sản phẩm..." class="form-control">
                            <span class="search-icon"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <!-- Sắp xếp -->
                    <div class="mb-5">
                        <h3 class="filter-title">Sắp xếp theo</h3>
                        <select name="sort" class="form-control"> <!-- Removed inline style -->
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Mặc định</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Tên: A - Z</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter w-100">Áp dụng bộ lọc</button>
                    
                    @if(request()->hasAny(['search', 'sort', 'min_price', 'max_price']))
                        <a href="{{ route('fe.category', $category->id) }}" 
                           class="text-center d-block mt-3 small text-muted text-uppercase" 
                           style="letter-spacing: 1px; text-decoration: none;">Xóa tất cả bộ lọc</a>
                    @endif
                </form>
            </aside>

            <!-- Danh sách sản phẩm bên phải -->
            <div class="col-lg-9">
                <div class="product-grid">
                    @forelse ($products as $product)
                        <article class="product-card">
                            <div class="card-image">
                                <a href="{{ route('fe.product.detail', $product->slug) }}">
                                    <img src="{{ $product->images ?? asset('img/default.jpg') }}" alt="{{ $product->name }}"
                                        loading="lazy" />
                                </a>
                                <button class="add-to-cart-btn btn-add-to-cart" data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                    data-image="{{ $product->images ?? asset('img/default.jpg') }}">
                                    <svg style="width:16px; height:16px" viewBox="0 0 24 24" stroke="currentColor" fill="none"
                                        stroke-width="2">
                                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                        <line x1="3" y1="6" x2="21" y2="6" />
                                        <path d="M16 10a4 4 0 01-8 0" />
                                    </svg>
                                    Thêm vào giỏ
                                </button>
                            </div>
                            <div class="card-info mt-3">
                                <h3 class="card-name">
                                    <a href="{{ route('fe.product.detail', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="card-prices">
                                    <span class="price-sale">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p>Không tìm thấy sản phẩm nào phù hợp với khoảng giá này.</p>
                            <a href="{{ route('fe.category', $category->id) }}" class="btn btn-dark">Xem tất cả sản phẩm</a>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function setPriceRange(min, max) {
            document.getElementById('min_price').value = min;
            document.getElementById('max_price').value = max;
        }

        $(document).ready(function() {
            // Xử lý thêm vào giỏ hàng
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
                    cart.push({
                        id,
                        name,
                        price,
                        image,
                        qty: 1,
                        size: null
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));

                // Cập nhật giao diện giỏ hàng và hiển thị sidebar/modal giỏ hàng
                updateCartUI();
                toggleCart();
            });
        });
    </script>
@endpush
