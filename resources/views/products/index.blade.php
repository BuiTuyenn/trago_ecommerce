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
                                    @php
                                        $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                                        $firstImage = is_array($images) && !empty($images) ? $images[0] : ($product->image ?? 'placeholder.jpg');
                                    @endphp
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ asset('images/' . $firstImage) }}" 
                                             class="card-img-top" alt="{{ $product->name }}" 
                                             style="height: 200px; object-fit: cover;">
                                    </a>
                                    
                                    <!-- Badges -->
                                    @if($product->created_at->diffInDays() < 7)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                                    @endif
                                    
                                    @if(isset($product->sale_price) && $product->sale_price)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <!-- Product Name -->
                                    <h5 class="card-title">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ Str::limit($product->name, 50) }}
                                        </a>
                                    </h5>

                                    <!-- Category -->
                                    @if($product->category)
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                        </p>
                                    @endif

                                    <!-- Price -->
                                    <div class="price-wrap mb-2">
                                        @if(isset($product->sale_price) && $product->sale_price > 0)
                                            <span class="text-danger fw-bold fs-5">{{ number_format((float)$product->sale_price) }}₫</span>
                                            <del class="text-muted ms-2">{{ number_format((float)$product->price) }}₫</del>
                                        @else
                                            <span class="text-dark fw-bold fs-5">{{ number_format((float)($product->price ?? 0)) }}₫</span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    <div class="rating mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <small class="text-muted ms-1">({{ rand(10, 100) }})</small>
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="stock-status mb-3">
                                        @if($product->stock_quantity > 0)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>Còn {{ $product->stock_quantity }} sản phẩm
                                            </small>
                                        @else
                                            <small class="text-danger">
                                                <i class="fas fa-times-circle me-1"></i>Hết hàng
                                            </small>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-auto d-grid gap-2">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                        @if($product->stock_quantity > 0)
                                            <button class="btn btn-primary btn-sm add-to-cart-btn" 
                                                    data-product-id="{{ $product->id }}">
                                                <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-times me-1"></i>Hết hàng
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-5x text-muted mb-3"></i>
                        <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating']))
                                Không tìm thấy sản phẩm nào phù hợp với bộ lọc hiện tại. Hãy thử thay đổi điều kiện tìm kiếm.
                            @else
                                Hiện tại chưa có sản phẩm nào trong hệ thống
                            @endif
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-1"></i>Xem tất cả sản phẩm
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

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
</style>
@endpush
@endsection