@extends('fe.layouts.home')

@section('page_title')
    Tất cả sản phẩm
@endsection

@section('content')
    <style>
        :root {
            --primary-black: #1a1a1a;
            --text-muted: #757575;
            --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .all-products-header {
            padding: 80px 0 40px;
            background: #fff;
            margin-bottom: 50px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .all-products-header h1 {
            font-size: 2rem;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 6px;
            margin-bottom: 15px;
            color: var(--primary-black);
        }

        .all-products-header p {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
        }

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
            transition: opacity 0.5s ease;
            backface-visibility: hidden;
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
        }

        .p-action-btn.view {
            background: rgba(255, 255, 255, 0.9);
            color: #000;
        }

        .p-action-btn.add {
            background: #000;
            color: #fff;
        }

        @media (max-width: 768px) {}

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

        .btn-filter:hover {
            background: #333;
        }

        .filter-sidebar .form-control {
            font-size: 12px;
            border-radius: 0;
            border: 1px solid #eee;
            padding: 8px 12px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .filter-sidebar .form-control:focus {
            border-color: var(--primary-black);
            box-shadow: none;
            outline: none;
        }

        .filter-sidebar .search-box {
            position: relative;
        }

        .filter-sidebar .search-box .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .filter-sidebar select.form-control {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

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

        .filter-radio-label:hover,
        .filter-radio-label:has(input:checked) {
            color: var(--primary-black);
            font-weight: 700;
        }

                /* --- Minimalist Filters Custom --- */
        .filters {
            margin-bottom: 50px !important;
            padding: 20px 0;
            border-top: 1px solid #f5f5f5;
            border-bottom: 1px solid #f5f5f5;
        }
        .filter-link {
            display: inline-block;
            color: #999;
            padding: 5px 0;
            margin-right: 30px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        .filter-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #000;
            transition: width 0.3s ease;
        }
        .filter-link.active {
            color: #000;
            font-weight: 700;
        }
        .filter-link.active::after, .filter-link:hover::after {
            width: 100%;
        }
        .filter-link:hover:not(.active) {
            color: #000;
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
                gap: 15px 10px;
                width: 100%;
            }

            .all-products-header h1 {
                font-size: 1.5rem;
            }

            .all-products-header {
                padding: 40px 0 20px;
            }

            .product-card-actions {
                opacity: 1;
                transform: translateY(0);
            }

            .p-action-btn {
                padding: 10px;
                font-size: 8px;
            }

            .card-info {
                padding: 12px 0;
            }

            .card-name a {
                font-size: 12px;
            }

            .price-sale {
                font-size: 12px;
            }

            .card-image {
                aspect-ratio: 3/4;
            }

            .card-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }
    </style>

    <header class="all-products-header">
        <div class="container">
            <h1>Tất cả sản phẩm</h1>
            <p>Khám phá bộ sưu tập mới nhất của chúng tôi</p>
        </div>
    </header>

    <main class="container mb-5">
        <div class="row">
            <!-- Sidebar bên trái -->
            <aside class="col-lg-3 filter-sidebar">
                <form action="{{ route('fe.products.all') }}" method="GET" id="filterForm">
                    <!-- Lọc theo giá -->
                    <div class="mb-5">
                        <h3 class="filter-title">Khoảng giá</h3>
                        <div class="price-ranges d-flex flex-column">
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="" {{ !request('min_price') && !request('max_price') ? 'checked' : '' }} onclick="setPriceRange('', '')">
                                Tất cả
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="0-500" {{ request('max_price') == 500000 ? 'checked' : '' }} onclick="setPriceRange('', 500000)">
                                Dưới 500.000₫
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="500-1000" {{ request('min_price') == 500000 && request('max_price') == 1000000 ? 'checked' : '' }}
                                    onclick="setPriceRange(500000, 1000000)">
                                500.000₫ - 1.000.000₫
                            </label>
                            <label class="filter-radio-label">
                                <input type="radio" name="price_range" value="1000-2000" {{ request('min_price') == 1000000 && request('max_price') == 2000000 ? 'checked' : '' }}
                                    onclick="setPriceRange(1000000, 2000000)">
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
                        <div class="search-box">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên sản phẩm..."
                                class="form-control">
                            <span class="search-icon"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <!-- Sắp xếp -->
                    <div class="mb-5">
                        <h3 class="filter-title">Sắp xếp theo</h3>
                        <select name="sort" class="form-control">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Mặc định</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Giá: Thấp đến Cao
                            </option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Giá: Cao đến
                                Thấp</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Tên: A - Z</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter w-100">Áp dụng bộ lọc</button>

                    @if(request()->hasAny(['search', 'sort', 'min_price', 'max_price']))
                        <a href="{{ route('fe.products.all') }}"
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
                                    <img src="{{ $product->images ?? asset('img/default.jpg') }}" class="main-img"
                                        alt="{{ $product->name }}" loading="lazy" />
                                    <img src="{{ $product->hover_image ?? ($product->images ?? asset('img/default.jpg')) }}"
                                        class="hover-img" alt="{{ $product->name }}" loading="lazy" />
                                </a>
                                <div class="product-card-actions">
                                    <a href="{{ route('fe.product.detail', $product->slug) }}" class="p-action-btn view">Xem chi
                                        tiết</a>
                                    <button class="p-action-btn add btn-add-to-cart" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                        data-image="{{ $product->images ?? asset('img/default.jpg') }}"
                                        data-sizes="{{ json_encode($product->sizes) }}">
                                        Thêm vào giỏ
                                    </button>
                                </div>
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
                            <p>Hiện chưa có sản phẩm nào phù hợp.</p>
                            <a href="{{ route('fe.products.all') }}" class="btn btn-dark">Xem tất cả sản phẩm</a>
                        </div>
                    @endforelse
                </div>

                <div class="custom-pagination mt-5">
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

        $(document).ready(function () {
            // Make applySort function globally accessible if needed by onchange attribute
            window.applySort = applySort;
        });
    </script>
@endpush