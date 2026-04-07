<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fashion Store — Thời trang & Giày dép hiện đại</title>
    <meta name="description" content="Cập nhật xu hướng thời trang mới nhất, giày dép và quần áo cao cấp." />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    @stack('styles')
</head>

<body>

    <!-- Top Bar -->
    <div class="top-bar">Miễn phí vận chuyển cho đơn hàng từ 500.000₫</div>

    <!-- Header -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="/" class="logo">
                <span class="text-gold-gradient" style="font-size: 1.5rem;">Nhà Bi</span>
            </a>
            <nav class="nav-links">
                <a href="#">Hàng Mới</a>
                <a href="#">Nam</a>
                <a href="#">Nữ</a>
                <a href="#">Giày Dép</a>
            </nav>
            <div class="header-actions">
                <button class="cart-btn" onclick="toggleCart()">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @stack('scripts')
</body>
</html>
