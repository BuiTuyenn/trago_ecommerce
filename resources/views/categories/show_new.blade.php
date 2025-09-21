@extends('layouts.app')

@section('title', $config['title'])

@section('content')
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
                                    <!-- Category -->
                                    <div class="product-category">
                                        <small class="text-muted">{{ $product->category->name ?? 'Danh mục' }}</small>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="product-title">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    
                                    <!-- Rating -->
                                    @if($product->reviews->count() > 0)
                                        <div class="product-rating">
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($product->average_rating))
                                                        <i class="fas fa-star star"></i>
                                                    @else
                                                        <i class="fas fa-star star empty"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="rating-count">({{ $product->reviews->count() }})</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Price -->
                                    <div class="product-price">
                                        @if(isset($product->sale_price) && $product->sale_price)
                                            <span class="current-price">{{ number_format((float)$product->sale_price) }}₫</span>
                                            <span class="original-price">{{ number_format((float)$product->price) }}₫</span>
                                        @else
                                            <span class="current-price">{{ number_format((float)$product->price) }}₫</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Stock Status -->
                                    <div class="stock-status">
                                        @if($product->quantity > 0)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Còn {{ $product->quantity }} sản phẩm
                                            </small>
                                        @else
                                            <small class="text-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Hết hàng
                                            </small>
                                        @endif
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="product-actions">
                                        @if($product->quantity > 0)
                                            <button class="btn btn-add-cart" data-product-id="{{ $product->id }}">
                                                <i class="fas fa-shopping-cart me-1"></i>
                                                Thêm vào giỏ
                                            </button>
                                        @else
                                            <button class="btn btn-add-cart" disabled>
                                                <i class="fas fa-times me-1"></i>
                                                Hết hàng
                                            </button>
                                        @endif
                                        
                                        <button class="btn btn-wishlist" data-product-id="{{ $product->id }}">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="category-pagination mt-4">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">Không tìm thấy sản phẩm</h3>
                        <p class="text-muted mb-4">
                            @if(request()->hasAny(['search', 'min_price', 'max_price', 'brand']))
                                Không có sản phẩm nào phù hợp với bộ lọc hiện tại.
                            @else
                                Danh mục này hiện chưa có sản phẩm nào.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'min_price', 'max_price', 'brand']))
                            <a href="{{ route('category.' . $categorySlug) }}" class="btn btn-primary">
                                <i class="fas fa-times me-1"></i>Xóa bộ lọc
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Add to cart functionality
function addToCart(productId) {
    // Implementation for adding to cart
    console.log('Adding product ' + productId + ' to cart');
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
