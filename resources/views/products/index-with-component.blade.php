@extends('layouts.app')

@section('title', 'Sản phẩm')

@vite(['resources/css/components/pagination/pagination.css'])

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Sản phẩm</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Product Filter Component -->
    <x-product-filter 
        :action="route('products.index')"
        headerTitle="Bộ lọc sản phẩm"
        headerBg="bg-primary"
        :resetRoute="route('products.index')"
        :showQuickFilter="true"
        :enableAutoSubmit="true"
        :filterParams="['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'sort']"
    />

    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="results-info">
                    <span class="text-muted">
                        Hiển thị {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} 
                        trong tổng số {{ number_format($products->total()) }} sản phẩm
                        @if(request('search'))
                            cho từ khóa "<strong>{{ request('search') }}</strong>"
                        @endif
                    </span>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <!-- Product Image -->
                                <div class="position-relative">
                                    @if($product->images_array && count($product->images_array) > 0)
                                        <img src="{{ asset('images/' . $product->images_array[0]) }}" 
                                             class="card-img-top" 
                                             alt="{{ $product->name }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    @if($product->created_at->diffInDays() < 7)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                                    @endif
                                    
                                    @if($product->sale_price)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    
                                    <!-- Price -->
                                    <div class="price-wrap mb-2">
                                        @if($product->sale_price)
                                            <span class="text-danger fw-bold current-price">{{ number_format($product->sale_price) }}₫</span>
                                            <span class="text-muted text-decoration-line-through ms-2 original-price">{{ number_format($product->price) }}₫</span>
                                        @else
                                            <span class="text-danger fw-bold current-price">{{ number_format($product->price) }}₫</span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="stars me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= ($product->average_rating ?? 0))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <small class="text-muted">({{ $product->reviews_count ?? 0 }})</small>
                                        </div>
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="mb-3">
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
                                    <div class="mt-auto">
                                        <div class="d-flex gap-2">
                                            @if($product->quantity > 0)
                                                <button class="btn btn-primary flex-fill add-to-cart-btn" 
                                                        data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                                </button>
                                            @else
                                                <button class="btn btn-secondary flex-fill" disabled>
                                                    <i class="fas fa-times me-1"></i>Hết hàng
                                                </button>
                                            @endif
                                            
                                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" 
                                               class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <button class="btn btn-outline-danger wishlist-btn" 
                                                    data-product-id="{{ $product->id }}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Không tìm thấy sản phẩm nào</h3>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating']))
                            Không tìm thấy sản phẩm nào phù hợp với bộ lọc hiện tại. Hãy thử thay đổi điều kiện tìm kiếm.
                        @else
                            Hiện tại chưa có sản phẩm nào trong hệ thống
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating']))
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-times me-1"></i>Xóa tất cả bộ lọc
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Product Card Font Size Overrides - Specific for Products Page */
.card-title,
.product-title,
.product-name,
h5.card-title,
.card-body .card-title,
.card-body h5 {
    font-size: 16px !important;
    line-height: 1.4 !important;
    font-weight: 600 !important;
}

.text-danger,
.current-price,
.original-price,
.price,
.product-price,
.text-muted,
small,
.rating-count,
.stock-status {
    font-size: 14px !important;
}

.form-select {
    font-size: 14px !important;
}

/* Product Card Styles */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.stars i {
    font-size: 0.875rem;
}

.price-wrap {
    min-height: 1.5rem;
}
</style>
@endpush

@push('scripts')
<script>
// Add to cart functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const originalText = this.innerHTML;
            
            // Disable button and show loading
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang thêm...';
            
            fetch('/cart/add', {
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
                    // Update cart count in header
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                    }
                    
                    // Show success message
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                    
                    // Change button text temporarily
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Đã thêm';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.disabled = false;
                    }, 2000);
                } else {
                    alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
});
</script>
@endpush
