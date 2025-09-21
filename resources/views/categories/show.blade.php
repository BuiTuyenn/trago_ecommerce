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

        <!-- Product Filter Component -->
        <x-product-filter 
            :action="request()->url()"
            headerTitle="Bộ lọc thông minh"
            headerBg="bg-success"
            :resetRoute="route('category.' . $categorySlug)"
            :showQuickFilter="true"
            :enableAutoSubmit="true"
            :filterParams="['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'brand', 'sort']"
        />
                            
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
                         @if(request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'stock_status', 'product_type', 'price_range', 'rating', 'brand']))
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
</script>
@endsection
