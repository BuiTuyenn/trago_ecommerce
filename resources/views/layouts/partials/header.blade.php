<!-- Trego Header -->
<header class="trego-header">
    <!-- Main Header Bar -->
    <div class="main-header-bar bg-white shadow-sm">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <!-- Logo -->
                <div class="col-lg-2 col-md-2 col-3">
                    <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center">
                        <span class="trego-brand-text">TREGO</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="col-lg-7 col-md-6 d-none d-md-block">
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

                <!-- User Menu & Cart -->
                <div class="col-lg-3 col-md-4 col-9">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <!-- User Menu -->
                        @auth
                            <div class="dropdown">
                                <a href="#" class="text-decoration-none text-dark dropdown-toggle d-flex align-items-center" 
                                   data-bs-toggle="dropdown">
                                    <div class="trego-user-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="d-none d-lg-block ms-2">
                                        <small class="d-block text-muted">Tài khoản</small>
                                        <strong>{{ Auth::user()->first_name ?? Auth::user()->name }}</strong>
                                    </div>
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
                            <a href="{{ route('login') }}" class="text-decoration-none text-dark d-flex align-items-center">
                                <div class="trego-user-icon">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="d-none d-lg-block ms-2">
                                    <small class="d-block text-muted">Đăng nhập</small>
                                    <strong>Tài khoản</strong>
                                </div>
                            </a>
                        @endauth

                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark position-relative">
                            <div class="trego-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="trego-cart-badge cart-count">
                                    {{ session('cart_count', 0) }}
                                </span>
                            </div>
                            <div class="d-none d-lg-block ms-2">
                                <small class="d-block text-muted">Giỏ hàng</small>
                                <strong>{{ session('cart_count', 0) }} sản phẩm</strong>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Features Bar -->
    <div class="service-features-bar bg-light border-top d-none d-md-block">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center gap-4 text-muted small">
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
</script>