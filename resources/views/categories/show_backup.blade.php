@extends('layouts.app')

@section('title', $config['title'] . ' - TreGo')

@section('content')
@vite(['resources/css/categories/category-master.css', 'resources/css/components/pagination/pagination.css'])
<script src="{{ asset('js/category-enhancements.js') }}" defer></script>

<div class="container-fluid p-0 category-page">
    <!-- Category Header -->
    <div class="category-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <i class="{{ $config['icon'] }} fa-2x me-3"></i>
                        <div>
                            <h1 class="category-title">{{ $config['title'] }}</h1>
                            <p class="category-description">{{ $config['description'] }}</p>
                        </div>
                    </div>
                    
                    <div class="category-stats">
                        <div class="stat-item">
                            <i class="fas fa-cube"></i>
                            <span>{{ number_format((int)$stats['total_products']) }} sản phẩm</span>
                        </div>
                        @if($stats['min_price'] > 0)
                        <div class="stat-item">
                            <i class="fas fa-tag"></i>
                            <span>Từ {{ number_format((float)$stats['min_price']) }}₫ - {{ number_format((float)$stats['max_price']) }}₫</span>
                        </div>
                        @endif
                        <div class="stat-item">
                            <i class="fas fa-star"></i>
                            <span>Chất lượng đảm bảo</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Giao hàng nhanh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="category-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index') }}">Danh mục</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $config['title'] }}</li>
                </ol>
            </nav>
        </div>

        <!-- Filter Section - Top Position -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-filter me-2"></i>Bộ lọc thông minh
                            </h5>
                            <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                                <i class="fas fa-chevron-up" id="filterToggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse show" id="filterCollapse">
                        <div class="card-body">
                            <form method="GET" class="filter-form">
                                <!-- Row 1: Search and Basic Filters -->
                                <div class="row g-3 mb-3">
                                    <!-- Search -->
                                    <div class="col-lg-3 col-md-6">
                                        <label for="search" class="form-label">
                                            <i class="fas fa-search me-1"></i>Tìm kiếm sản phẩm
                                        </label>
                                        <input type="text" class="form-control" id="search" name="search" 
                                               value="{{ request('search') }}" placeholder="Nhập tên sản phẩm...">
                                    </div>
                                    
                                    <!-- Price Range -->
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label">
                                            <i class="fas fa-dollar-sign me-1"></i>Khoảng giá
                                        </label>
                                        <div class="row g-2">
                                            <div class="col">
                                                <input type="number" class="form-control" id="min_price" name="min_price" 
                                                       value="{{ request('min_price') }}" placeholder="Từ" min="0">
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <span class="text-muted">-</span>
                                            </div>
                                            <div class="col">
                                                <input type="number" class="form-control" id="max_price" name="max_price" 
                                                       value="{{ request('max_price') }}" placeholder="Đến" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Brand Filter -->
                                    @if(isset($filterOptions['brands']))
                                    <div class="col-lg-3 col-md-6">
                                        <label for="brand" class="form-label">
                                            <i class="fas fa-copyright me-1"></i>Thương hiệu
                                        </label>
                                        <select class="form-select" id="brand" name="brand">
                                            <option value="">Tất cả thương hiệu</option>
                                            @foreach(array_slice($filterOptions['brands'], 0, 10) as $brand)
                                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                                    {{ $brand }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    
                                    <!-- Filter Buttons -->
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-search me-1"></i>Lọc
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Reset Button Row -->
                                @if(request()->hasAny(['search', 'min_price', 'max_price', 'brand', 'featured', 'on_sale']))
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <a href="{{ route('category.' . $categorySlug) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i>Xóa tất cả bộ lọc
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="row">
            <div class="col-12">
                <!-- Results Info -->
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-microchip me-2"></i>Bộ xử lý
                            </h5>
                            <div class="filter-options">
                                @foreach(array_slice($filterOptions['processors'], 0, 6) as $processor)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="processor" 
                                               value="{{ $processor }}" id="processor_{{ $loop->index }}"
                                               {{ request('processor') == $processor ? 'checked' : '' }}>
                                        <label class="form-check-label" for="processor_{{ $loop->index }}">
                                            {{ $processor }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($filterOptions['ram']))
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-memory me-2"></i>RAM
                            </h5>
                            <div class="filter-options">
                                @foreach($filterOptions['ram'] as $ram)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ram" 
                                               value="{{ $ram }}" id="ram_{{ $loop->index }}"
                                               {{ request('ram') == $ram ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ram_{{ $loop->index }}">
                                            {{ $ram }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($filterOptions['authors']))
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-user-edit me-2"></i>Tác giả
                            </h5>
                            <div class="filter-options">
                                @foreach($filterOptions['authors'] as $author)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="author" 
                                               value="{{ $author }}" id="author_{{ $loop->index }}"
                                               {{ request('author') == $author ? 'checked' : '' }}>
                                        <label class="form-check-label" for="author_{{ $loop->index }}">
                                            {{ $author }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($filterOptions['age_groups']))
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-child me-2"></i>Độ tuổi
                            </h5>
                            <div class="filter-options">
                                @foreach($filterOptions['age_groups'] as $age)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="age_group" 
                                               value="{{ $age }}" id="age_{{ $loop->index }}"
                                               {{ request('age_group') == $age ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age_{{ $loop->index }}">
                                            {{ $age }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($filterOptions['sizes']))
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-ruler me-2"></i>Kích thước
                            </h5>
                            <div class="filter-options size-options">
                                @foreach($filterOptions['sizes'] as $size)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="size" 
                                               value="{{ $size }}" id="size_{{ $loop->index }}"
                                               {{ request('size') == $size ? 'checked' : '' }}>
                                        <label class="form-check-label size-label" for="size_{{ $loop->index }}">
                                            {{ $size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(isset($filterOptions['colors']))
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-palette me-2"></i>Màu sắc
                            </h5>
                            <div class="filter-options">
                                @foreach(array_slice($filterOptions['colors'], 0, 6) as $color)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" 
                                               value="{{ $color }}" id="color_{{ $loop->index }}"
                                               {{ request('color') == $color ? 'checked' : '' }}>
                                        <label class="form-check-label" for="color_{{ $loop->index }}">
                                            {{ $color }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Special Filters -->
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-star me-2"></i>Đặc biệt
                            </h5>
                            <div class="filter-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured"
                                           {{ request('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">
                                        <i class="fas fa-star text-warning me-1"></i>Sản phẩm nổi bật
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="on_sale" value="1" id="on_sale"
                                           {{ request('on_sale') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="on_sale">
                                        <i class="fas fa-percent text-danger me-1"></i>Đang giảm giá
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="in_stock"
                                           {{ request('in_stock') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="in_stock">
                                        <i class="fas fa-check-circle text-success me-1"></i>Còn hàng
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="sidebar-section">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Áp dụng bộ lọc
                            </button>
                        </div>

                        <!-- Category Stats -->
                        @if($stats['total_products'] > 0)
                        <div class="sidebar-section">
                            <h5 class="sidebar-title">
                                <i class="fas fa-chart-bar me-2"></i>Thống kê danh mục
                            </h5>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format((int)$stats['total_products']) }}</div>
                                    <div class="stat-label">Sản phẩm</div>
                                </div>
                                @if($stats['avg_price'] > 0)
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format((float)$stats['avg_price']) }}₫</div>
                                    <div class="stat-label">Giá TB</div>
                                </div>
                                @endif
                                @if($priceRange['min'] > 0 && $priceRange['max'] > 0)
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format((float)$priceRange['min']) }}₫</div>
                                    <div class="stat-label">Giá thấp nhất</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ number_format((float)$priceRange['max']) }}₫</div>
                                    <div class="stat-label">Giá cao nhất</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Filter & Sort Section -->
                <div class="filter-sort-section">
                    <form method="GET" class="filter-form">
                        @foreach(request()->except(['search', 'sort', 'order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <div class="filter-row">
                            <!-- Search -->
                            <div class="filter-group flex-grow-1">
                                <label for="search">Tìm kiếm</label>
                                <input type="text" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Tìm kiếm sản phẩm...">
                            </div>
                            
                            <!-- Sort -->
                            <div class="filter-group">
                                <label for="sort">Sắp xếp theo</label>
                                <select id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>
                                        Mới nhất
                                    </option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                        Giá thấp đến cao
                                    </option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                        Giá cao đến thấp
                                    </option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                        Tên A-Z
                                    </option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                        Phổ biến
                                    </option>
                                </select>
                            </div>
                            
                            <!-- Actions -->
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('category.' . $categorySlug) }}" class="btn-clear">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Info -->
                @if($products->total() > 0)
                <div class="results-info mb-3">
                    <p class="text-muted">
                        Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} 
                        trong tổng số {{ number_format((int)$products->total()) }} sản phẩm
                        @if(request('search'))
                            cho từ khóa "<strong>{{ request('search') }}</strong>"
                        @endif
                    </p>
                </div>
                @endif

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <!-- Product Image -->
                                <div class="product-image">
                                    @if($product->image)
                                        <img src="{{ asset('images/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             loading="lazy">
                                    @else
                                        <div class="placeholder-image d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    @if($product->created_at->diffInDays() < 7)
                                        <div class="product-badge new">Mới</div>
                                    @elseif(isset($product->sale_price) && $product->sale_price)
                                        <div class="product-badge">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="#" class="text-decoration-none">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <!-- Price -->
                                    <div class="product-price">
                                        @if(isset($product->sale_price) && $product->sale_price > 0)
                                            <span class="current-price">{{ number_format((float)$product->sale_price) }}₫</span>
                                            <span class="original-price">{{ number_format((float)$product->price) }}₫</span>
                                            <span class="discount-percent">
                                                -{{ round((((float)$product->price - (float)$product->sale_price) / (float)$product->price) * 100) }}%
                                            </span>
                                        @else
                                            <span class="current-price">{{ number_format((float)($product->price ?? 0)) }}₫</span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    <div class="product-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star star {{ $i <= 4 ? '' : 'empty' }}"></i>
                                            @endfor
                                        </div>
                                        <span class="rating-count">({{ rand(10, 100) }})</span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="product-actions">
                                        <button class="btn-add-cart" onclick="addToCart({{ $product->id }})">
                                            <i class="fas fa-cart-plus me-1"></i>
                                            Thêm vào giỏ
                                        </button>
                                        <button class="btn-wishlist" onclick="toggleWishlist({{ $product->id }})">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="category-pagination d-flex justify-content-center mt-5">
                        {{ $products->links('vendor.pagination.custom') }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>Không tìm thấy sản phẩm</h3>
                        <p>
                            @if(request('search'))
                                Không có sản phẩm nào phù hợp với từ khóa "{{ request('search') }}"
                            @else
                                Danh mục này hiện chưa có sản phẩm nào
                            @endif
                        </p>
                        <a href="{{ route('category.' . $categorySlug) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>Xem tất cả sản phẩm
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Add to cart function
function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
            
            // Show success message
            showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
        } else {
            showToast(data.message || 'Có lỗi xảy ra!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra khi thêm vào giỏ hàng!', 'error');
    });
}

// Toggle wishlist function
function toggleWishlist(productId) {
    @auth
    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = event.target.closest('.btn-wishlist');
            if (data.action === 'added') {
                button.classList.add('active');
                showToast('Đã thêm vào danh sách yêu thích!', 'success');
            } else {
                button.classList.remove('active');
                showToast('Đã xóa khỏi danh sách yêu thích!', 'info');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Có lỗi xảy ra!', 'error');
    });
    @else
    showToast('Vui lòng đăng nhập để sử dụng tính năng này!', 'warning');
    setTimeout(() => {
        window.location.href = '{{ route("login") }}';
    }, 2000);
    @endauth
}

// Use the enhanced toast system
function showToast(message, type = 'info') {
    if (window.CategoryEnhancements) {
        window.CategoryEnhancements.showToast(message, type);
    } else {
        // Fallback for when enhancements haven't loaded yet
        alert(message);
    }
}

// Auto-submit search form on input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }
});
</script>
@endsection
