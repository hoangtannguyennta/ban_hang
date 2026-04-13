@extends('fe.layouts.home')

@section('page_title')
    Tất cả sản phẩm
@endsection

@section('content')
    <style>
        .all-products-header {
            padding: 60px 0;
            background: #f9f9f9;
            margin-bottom: 50px;
            text-align: center;
        }

        .all-products-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .product-card {
            border: none;
            transition: all 0.3s ease;
        }

        .card-name a {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            color: #000;
            text-decoration: none;
        }

        .price-sale {
            font-weight: 500;
            color: #666;
            font-size: 13px;
        }

        .add-to-cart-btn {
            background: #000;
            border-radius: 0;
            opacity: 0;
            transition: 0.3s;
        }

        .product-card:hover .add-to-cart-btn {
            opacity: 1;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }
    </style>

    <header class="all-products-header">
        <div class="container">
            <h1>Tất cả sản phẩm</h1>
            <p class="text-muted">Khám phá bộ sưu tập mới nhất của chúng tôi</p>
        </div>
    </header>

    <main class="container mb-5">
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
                    <p>Hiện chưa có sản phẩm nào.</p>
                    <a href="{{ route('fe.home') }}" class="btn btn-dark">Quay lại trang chủ</a>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </main>
@endsection

@push('scripts')
    <script>
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
