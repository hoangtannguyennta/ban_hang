<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nhà Bi Store — Thời trang & Giày dép hiện đại</title>
    <meta name="description" content="Cập nhật xu hướng thời trang mới nhất, giày dép và quần áo cao cấp." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('bootraps/css/bootstrap.min.css') }}">
    <style>
        :root {
            --primary-color: #000000;
            --text-color: #000000;
            --light-gray: #f5f5f5;
            --border-color: #e5e5e5;
            --font-main: 'Jost', sans-serif;
        }
        body {
            font-family: var(--font-main);
            color: var(--text-color);
            letter-spacing: 0.5px;
        }
        .top-bar {
            background: var(--primary-color);
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 2px;
            font-weight: 500;
            padding: 8px 0;
        }
        .site-header {
            border-bottom: 1px solid #222;
            background: #000;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 10px 0;
        }
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .logo {
            text-decoration: none;
            color: #fff !important;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 1.8rem !important;
            justify-self: center;
            display: flex;
            align-items: center;
        }
        .nav-links {
            display: flex;
        }
        .nav-links a {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 13px;
            margin: 0 15px;
            letter-spacing: 1px;
            color: #fff;
            text-decoration: none;
        }
        .nav-links a.active {
            border-bottom: 2px solid var(--gold);
            padding-bottom: 4px;
            font-weight: 800;
            color: var(--gold);
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .cart-btn, .menu-toggle {
            background: none;
            border: none;
            color: #fff;
            padding: 0;
            cursor: pointer;
        }
        .menu-toggle {
            display: none;
        }

        /* Mobile Nav Sidebar */
        .mobile-nav-sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: #fff;
            z-index: 1100;
            transition: 0.3s;
            padding: 40px 20px;
        }
        .mobile-nav-sidebar.open {
            left: 0;
        }
        .mobile-nav-sidebar a {
            display: block;
            color: #000;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .mobile-nav-sidebar a.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-left: 10px;
        }

        @media (max-width: 991px) {
            .nav-links {
                display: none;
            }
            .menu-toggle {
                display: block;
            }
            .header-inner {
                grid-template-columns: auto 1fr auto;
            }
            .logo {
                order: 2;
            }
            .menu-toggle {
                order: 1;
            }
            .header-actions {
                order: 3;
            }
        }
        .cart-badge {
            background: #fff;
            color: #000;
        }
        .site-footer {
            background: #fff;
            border-top: 1px solid var(--border-color);
            padding: 60px 0 30px;
            text-align: center;
        }
        .footer-logo {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .footer-logo span {
            background: none !important;
            -webkit-text-fill-color: initial !important;
            color: #000;
        }
        .footer-links a {
            color: #666;
            text-transform: uppercase;
            font-size: 11px;
            margin: 0 10px;
            letter-spacing: 1px;
        }
        .btn-checkout {
            background: #000;
            border-radius: 0;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }
          /* --- Custom Pagination Style (Black & White) --- */
        .custom-pagination {
            margin-top: 60px;
        }
        .custom-pagination .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            list-style: none;
            padding: 0;
        }
        .custom-pagination .page-item .page-link {
            color: var(--primary-black);
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition-smooth);
            border-radius: 0; /* Vuông vức sang trọng */
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
        }
        .custom-pagination .page-item.active .page-link {
            background-color: var(--primary-black);
            border-color: var(--primary-black);
            color: #fff;
        }
        .custom-pagination .page-item .page-link:hover {
            background-color: var(--primary-black);
            color: #fff;
            border-color: var(--primary-black);
        }
        .custom-pagination .page-item.disabled .page-link {
            color: #ccc;
            border-color: #f5f5f5;
            background-color: #fff;
        }

        /* Size Modal Custom */
        .size-option {
            border: 1px solid #e0e0e0;
            padding: 10px 18px;
            cursor: pointer;
            transition: all 0.25s ease;
            min-width: 55px;
            text-align: center;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            background: #fff;
            color: #555;
        }
        .size-option:hover { 
            border-color: #000; 
            color: #000;
        }
        .size-option.selected { 
            background: #000; 
            color: #fff; 
            border-color: #000; 
        }
        
        #sizeModal .modal-content {
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            border: 1px solid #f0f0f0;
        }

        .modal-product-img img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 767px) {
            .modal-product-img img {
                height: 300px;
            }
        }

        /* Style cho phần chữ Hiển thị kết quả của Laravel */
        .custom-pagination nav .flex.justify-between.flex-1.sm\:hidden { display: none; } /* Ẩn navigation mobile mặc định của tailwind */
        .custom-pagination nav > div:first-child {
            margin-bottom: 15px;
            text-align: center;
        }
        .custom-pagination nav p.text-sm.text-gray-700 {
            font-size: 11px !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted) !important;
            margin: 0;
        }
        .custom-pagination nav p.text-sm.text-gray-700 font { font-weight: 700; color: #000; }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Top Bar -->
    {{-- <div class="top-bar" style="text-align: center; color: #fff;">Miễn phí vận chuyển cho đơn hàng từ 500.000₫</div> --}}

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner">
            <button class="menu-toggle" onclick="toggleMenu()">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <a href="{{ route('fe.home') }}" class="logo">
                <img src="{{ asset('images/logo debaek-05.png') }}" alt="Logo">
            </a>

            <nav class="nav-links">
                @foreach($categories as $category)
                    <a href="{{ route('fe.category', $category->id) }}" 
                       class="{{ (request()->routeIs('fe.category') && request()->route('id') == $category->id) ? 'active' : '' }}">
                        {{ $category->name }}</a>
                @endforeach
            </nav>

            <div class="header-actions">
                <button class="cart-btn" onclick="toggleCart()" aria-label="Giỏ hàng">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 01-8 0" />
                    </svg>
                    <span class="cart-badge" id="cartCount">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Size Selection Modal -->
    <div class="modal fade" id="sizeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 0; border: none;">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 15px; right: 15px; z-index: 10;"></button>
                    <div class="row g-0">
                        <!-- Left: Image -->
                        <div class="col-md-6">
                            <div class="modal-product-img h-100 bg-light">
                                <img id="modalProductImage" src="" alt="">
                            </div>
                        </div>
                        <!-- Right: Info -->
                        <div class="col-md-6 p-4 p-md-5 d-flex flex-column justify-content-center">
                            <div id="modalProductInfo" class="mb-5">
                                <h6 class="text-uppercase text-muted mb-3" style="letter-spacing: 3px; font-size: 10px; font-weight: 700;">Tùy chọn sản phẩm</h6>
                                <h3 id="modalProductName" class="mb-3" style="font-family: var(--font-heading); font-size: 1.8rem; letter-spacing: 1px; color: #1a1a1a;"></h3>
                                <h4 id="modalProductPrice" class="text-gold-gradient fw-bold mb-0" style="font-size: 1.4rem; letter-spacing: 1px;"></h4>
                            </div>

                            <div class="mb-5">
                                <p class="small text-muted mb-3 text-uppercase" style="font-size: 10px; letter-spacing: 2px; font-weight: 600;">Kích cỡ khả dụng:</p>
                                <div class="d-flex flex-wrap gap-2" id="sizeList">
                                    <!-- Sizes injected here -->
                                </div>
                                <div id="sizeError" class="text-danger small mt-2" style="display:none;">Vui lòng chọn kích cỡ</div>
                            </div>

                            <button type="button" class="btn btn-dark w-100 text-uppercase" 
                                style="border-radius: 0; letter-spacing: 3px; font-size: 11px; height: 55px; font-weight: 700;" 
                                id="btnConfirmAddToCart">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <aside class="mobile-nav-sidebar" id="mobileNav">
        @foreach($categories as $category)
            <a href="{{ route('fe.category', $category->id) }}"
               class="{{ (request()->routeIs('fe.category') && request()->route('id') == $category->id) ? 'active' : '' }}">
                {{ $category->name }}</a>
        @endforeach
    </aside>
    <div class="cart-overlay" id="menuOverlay" onclick="toggleMenu()"></div>

    @yield('content')

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-logo"><span class="text-gold-gradient">Nhà Bi</span></div>
            <p class="footer-tagline">Nâng tầm phong cách cá nhân của bạn mỗi ngày.</p>
            <div class="footer-links">
                <a href="#">Giới thiệu</a>
                <a href="#">Liên hệ</a>
                <a href="#">Chính sách</a>
                <a href="#">Hỗ trợ</a>
            </div>
            <p class="footer-copy">© 2026 Nhà Bi - Góc nhỏ an yên . Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- Cart Overlay -->
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
    <aside class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>Giỏ hàng</h3>
            <button class="cart-close" onclick="toggleCart()">
                <svg class="icon" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <p class="cart-empty">Giỏ hàng trống</p>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Tổng cộng</span>
                <span class="total-price" id="cartTotal">0₫</span>
            </div>
            <a href="{{ route('fe.checkout') }}" class="btn-checkout">Thanh toán</a>
        </div>
    </aside>

    <script src="{{ asset('bootraps/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        // Mobile Menu Toggle
        function toggleMenu() {
            $('#mobileNav, #menuOverlay').toggleClass('open');
        }

        // Hàm đóng/mở giỏ hàng
        function toggleCart() {
            $('#cartSidebar, #cartOverlay').toggleClass('open');
        }

        // Hàm cập nhật giao diện giỏ hàng toàn trang
        function updateCartUI() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
            $('#cartCount, .cart-badge').text(totalQty);

            const $cartList = $('#cartItems');
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
                $('#cartTotal, .total-price').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + '₫');
            }
        }

        // Global Add to Cart Logic
        function addToCart(id, name, price, image, size) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingItem = cart.find(item => item.id == id && item.size == size);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ id, name, price, image, qty: 1, size });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
            toggleCart();
        }

        $(document).ready(function() {
            updateCartUI();

            // Handle Add to Cart button click
            $(document).on('click', '.btn-add-to-cart', function() {
                const data = $(this).data();
                const sizes = data.sizes;

                if (sizes && Array.isArray(sizes) && sizes.length > 0) {
                    $('#modalProductName').text(data.name);
                    $('#modalProductPrice').text(new Intl.NumberFormat('vi-VN').format(data.price) + '₫');
                    $('#modalProductImage').attr('src', data.image);
                    let sizeHtml = '';
                    sizes.forEach(s => {
                        sizeHtml += `<div class="size-option" data-size="${s}">${s}</div>`;
                    });
                    $('#sizeList').html(sizeHtml);
                    $('#btnConfirmAddToCart').data(data);
                    $('#sizeError').hide();
                    $('#sizeModal').modal('show');
                } else {
                    addToCart(data.id, data.name, data.price, data.image, null);
                }
            });

            $(document).on('click', '.size-option', function() {
                $('.size-option').removeClass('selected');
                $(this).addClass('selected');
                $('#sizeError').hide();
            });

            $('#btnConfirmAddToCart').on('click', function() {
                const size = $('.size-option.selected').data('size');
                if (!size) { $('#sizeError').show(); return; }
                const data = $(this).data();
                addToCart(data.id, data.name, data.price, data.image, size);
                $('#sizeModal').modal('hide');
            });

            // Xử lý xóa sản phẩm khỏi giỏ hàng
            $(document).on('click', '.cart-remove', function() {
                const id = $(this).data('id');
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart = cart.filter(item => item.id != id);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            });

            // Xử lý tăng giảm số lượng trong giỏ hàng
            $(document).on('click', '.btn-qty', function() {
                const id = $(this).data('id');
                const delta = parseInt($(this).data('delta'));
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const item = cart.find(c => c.id == id);
                if (item) {
                    item.qty += delta;
                    if (item.qty <= 0) cart = cart.filter(c => c.id != id);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartUI();
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
