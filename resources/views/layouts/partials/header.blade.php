<!-- Trego Header -->
<header class="trego-header">
    <!-- Main Header Bar -->
    <div class="main-header-bar bg-white shadow-sm">
        <div class="container-fluid">
            <!-- Top Row: Logo + Search Bar + Right Menu -->
            <div class="d-flex align-items-center py-2 gap-3">
                <!-- Logo -->
                <div class="header-logo-section">
                    <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                        <span class="trego-brand-text">TREGO</span>
                    </a>
                </div>

                <!-- Search Bar (middle) -->
                <div class="flex-grow-1 d-none d-md-block">
                    <form action="{{ route('products.search') }}" method="GET" class="position-relative">
                        <div class="trego-search-bar">
                            <input type="text" name="q" class="form-control trego-search-input" 
                                   placeholder="Freeship đơn từ 45k" 
                                   value="{{ request('q') }}">
                            <button class="btn btn-primary trego-search-btn" type="submit">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Side Menu -->
                <div class="d-flex align-items-center gap-4 d-none d-md-flex">
                    <!-- Trang chủ -->
                    <a href="{{ route('home') }}" class="header-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home me-1"></i>
                        <span>Trang chủ</span>
                    </a>

                    <!-- Trego VIP Section (only for authenticated users) -->
                    @auth
                        <a href="#" class="header-nav-link trego-vip-section" id="tregoVipSection">
                            <i class="fas fa-crown me-1"></i>
                            <span>Trego VIP</span>
                        </a>
                    @endauth

                    <!-- User Account -->
                    @auth
                        <div class="dropdown">
                            <a href="#" class="header-nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                <span>Tài khoản</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>Tài khoản của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Quản trị hệ thống
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="header-nav-link">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            <span>Tài khoản</span>
                        </a>
                    @endauth

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="header-nav-link position-relative">
                        <i class="fas fa-shopping-cart me-1"></i>
                        <span class="cart-count-badge">{{ session('cart_count', 0) }}</span>
                    </a>
                </div>

                <!-- Mobile Right Menu -->
                <div class="d-flex align-items-center justify-content-end gap-2 d-md-none">
                    <!-- Mobile Account -->
                    @auth
                        <div class="dropdown">
                            <a href="#" class="header-nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>Tài khoản của tôi
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                                </a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Quản trị hệ thống
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="header-nav-link">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    @endauth

                    <!-- Mobile Cart -->
                    <a href="{{ route('cart.index') }}" class="header-nav-link position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count-badge">{{ session('cart_count', 0) }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Menu Bar (below search) -->
    <!-- <div class="categories-menu-bar bg-white border-top d-none d-md-block">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center gap-4">
                        <a href="#" class="category-link">điện gia dụng</a>
                        <a href="#" class="category-link">xe cộ</a>
                        <a href="#" class="category-link">mẹ & bé</a>
                        <a href="#" class="category-link">khỏe đẹp</a>
                        <a href="#" class="category-link">nhà cửa</a>
                        <a href="#" class="category-link">sách</a>
                        <a href="#" class="category-link">thể thao</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Service Features Bar -->
    <div class="service-features-bar bg-light border-top d-none d-md-block">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-start gap-4 text-muted small">
                        <span class="fw-bold text-dark">Cam kết</span>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>100% hàng thật</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-shipping-fast text-primary"></i>
                            <span>Freeship mọi đơn</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-undo text-warning"></i>
                            <span>Hoàn 200% nếu hàng giả</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt text-info"></i>
                            <span>30 ngày đổi trả</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-clock text-success"></i>
                            <span>Giao hàng 2h</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-tag text-danger"></i>
                            <span>Giá siêu rẻ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Search Bar -->
    <div class="d-md-none bg-light border-top">
        <div class="container py-3">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="trego-search-bar">
                    <input type="text" name="q" class="form-control trego-search-input" 
                           placeholder="Freeship đơn từ 45k" 
                           value="{{ request('q') }}">
                    <button class="btn btn-primary trego-search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Header JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update cart count on page load
    updateCartCount();
});

// Update cart count function
function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.count;
            });
        })
        .catch(error => {
            console.error('Error updating cart count:', error);
        });
}

// Global function to update cart count (called from other scripts)
window.updateCartCount = updateCartCount;

// Trego VIP Section Click Handler
document.addEventListener('DOMContentLoaded', function() {
    const tregoVipSection = document.getElementById('tregoVipSection');
    if (tregoVipSection) {
        tregoVipSection.addEventListener('click', function(e) {
            e.preventDefault();
            // TODO: Implement membership/VIP features
            alert('Tính năng Trego VIP sẽ sớm ra mắt! 👑\n\nChúng tôi đang phát triển các ưu đại đặc biệt dành cho thành viên VIP.');
        });
    }
});
</script>