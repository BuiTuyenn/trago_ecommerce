@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                @if($product->image)
                    <div class="main-image mb-3">
                        <img src="{{ asset('images/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded shadow"
                             id="main-product-image">
                    </div>
                @else
                    <div class="main-image mb-3 bg-light d-flex align-items-center justify-content-center rounded shadow" 
                         style="height: 400px;">
                        <i class="fas fa-image fa-5x text-muted"></i>
                    </div>
                @endif

                @if($product->images_array && count($product->images_array) > 1)
                    <div class="thumbnail-images d-flex gap-2">
                        @foreach($product->images_array as $image)
                            <img src="{{ asset('images/' . $image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-thumbnail thumbnail-image" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <h1 class="h2 mb-3">{{ $product->name }}</h1>
                
                <!-- Rating and Reviews -->
                @if($product->reviews->count() > 0)
                    <div class="rating-section mb-3">
                        <div class="d-flex align-items-center">
                            <div class="stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->average_rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text me-3">{{ number_format($product->average_rating, 1) }}</span>
                            <span class="review-count text-muted">({{ $product->reviews->count() }} đánh giá)</span>
                        </div>
                    </div>
                @endif

                <!-- Price -->
                <div class="price-section mb-4">
                    @if($product->sale_price && $product->sale_price < $product->price)
                        <div class="d-flex align-items-center gap-3">
                            <span class="sale-price h3 text-danger mb-0">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                            <span class="original-price text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            <span class="discount-badge badge bg-danger">
                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </span>
                        </div>
                    @else
                        <span class="price h3 text-primary mb-0">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>SKU:</strong> {{ $product->sku }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Danh mục:</strong> 
                            @if($product->category)
                                <a href="{{ route('products.category', $product->category->slug) }}" class="text-decoration-none">
                                    {{ $product->category->name }}
                                </a>
                            @else
                                Chưa phân loại
                            @endif
                        </div>
                        <div class="col-sm-6 mt-2">
                            <strong>Tình trạng:</strong> 
                            @if($product->in_stock)
                                <span class="text-success">Còn hàng ({{ $product->stock_quantity }} sản phẩm)</span>
                            @else
                                <span class="text-danger">Hết hàng</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if($product->in_stock)
                    <div class="add-to-cart-section mb-4">
                        <form id="add-to-cart-form" class="d-flex flex-column flex-sm-row gap-3 align-items-start">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="quantity-selector">
                                <label for="quantity" class="form-label">Số lượng:</label>
                                <div class="input-group" style="width: 150px;">
                                    <button class="btn btn-outline-secondary" type="button" id="decrease-qty">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           class="form-control text-center" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock_quantity }}">
                                    <button class="btn btn-outline-secondary" type="button" id="increase-qty">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="cart-actions">
                                <button type="submit" class="btn btn-primary btn-lg me-2">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Thêm vào giỏ hàng
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-lg" id="buy-now">
                                    <i class="fas fa-flash me-2"></i>
                                    Mua ngay
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Sản phẩm này hiện tại đã hết hàng
                    </div>
                @endif

                <!-- Product Features -->
                <div class="product-features">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="feature-item p-3">
                                <i class="fas fa-shipping-fast text-primary fa-2x mb-2"></i>
                                <small class="d-block">Giao hàng nhanh</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-item p-3">
                                <i class="fas fa-undo text-primary fa-2x mb-2"></i>
                                <small class="d-block">Đổi trả 30 ngày</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="feature-item p-3">
                                <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                                <small class="d-block">Bảo hành chính hãng</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description" role="tab">
                                Mô tả sản phẩm
                            </a>
                        </li>
                        @if($product->reviews->count() > 0)
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#reviews" role="tab">
                                    Đánh giá ({{ $product->reviews->count() }})
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="description" role="tabpanel">
                            @if($product->description)
                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            @else
                                <p class="text-muted">Chưa có mô tả cho sản phẩm này.</p>
                            @endif
                        </div>
                        
                        @if($product->reviews->count() > 0)
                            <div class="tab-pane" id="reviews" role="tabpanel">
                                <div class="reviews-section">
                                    @foreach($product->reviews as $review)
                                        <div class="review-item border-bottom pb-3 mb-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $review->user->name }}</h6>
                                                    <div class="stars mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p class="mb-0">{{ $review->comment }}</p>
                                                </div>
                                                <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Sản phẩm liên quan</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100">
                                <div class="position-relative">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('images/' . $relatedProduct->image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $relatedProduct->name }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                            -{{ round((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100) }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ Str::limit($relatedProduct->name, 50) }}</h6>
                                    <div class="price-section mt-auto">
                                        @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-danger fw-bold">{{ number_format($relatedProduct->sale_price, 0, ',', '.') }}₫</span>
                                                <span class="text-muted text-decoration-line-through small">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</span>
                                            </div>
                                        @else
                                            <span class="text-primary fw-bold">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm">
                                            Xem chi tiết
                                        </a>
                                        @if($relatedProduct->in_stock)
                                            <button class="btn btn-primary btn-sm quick-add-to-cart" 
                                                    data-product-id="{{ $relatedProduct->id }}">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Quantity controls
    $('#decrease-qty').click(function() {
        let quantity = parseInt($('#quantity').val());
        if (quantity > 1) {
            $('#quantity').val(quantity - 1);
        }
    });

    $('#increase-qty').click(function() {
        let quantity = parseInt($('#quantity').val());
        let maxQuantity = parseInt($('#quantity').attr('max'));
        if (quantity < maxQuantity) {
            $('#quantity').val(quantity + 1);
        }
    });

    // Add to cart form
    $('#add-to-cart-form').submit(function(e) {
        e.preventDefault();
        
        const productId = $('input[name="product_id"]').val();
        const quantity = parseInt($('#quantity').val());
        
        addToCart(productId, quantity);
    });

    // Buy now button
    $('#buy-now').click(function() {
        const productId = $('input[name="product_id"]').val();
        const quantity = parseInt($('#quantity').val());
        
        // Add to cart then redirect to checkout
        $.post('{{ route("cart.add") }}', {
            product_id: productId,
            quantity: quantity,
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(data) {
            if (data.success) {
                window.location.href = '{{ route("cart.index") }}';
            } else {
                showAlert('error', data.message);
            }
        }).fail(function(xhr) {
            const response = xhr.responseJSON;
            showAlert('error', response.message || 'Có lỗi xảy ra');
        });
    });

    // Quick add to cart for related products
    $('.quick-add-to-cart').click(function() {
        const productId = $(this).data('product-id');
        addToCart(productId, 1);
    });

    // Thumbnail image click
    $('.thumbnail-image').click(function() {
        const newSrc = $(this).attr('src');
        $('#main-product-image').attr('src', newSrc);
    });

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('.container').prepend(alertHtml);
        
        // Auto dismiss after 3 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    }
});
</script>
@endpush

@push('styles')
<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.feature-item {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.quantity-selector .btn {
    border-color: #dee2e6;
}

.stars i {
    font-size: 14px;
}

.review-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

@media (max-width: 768px) {
    .add-to-cart-section .d-flex {
        flex-direction: column;
        align-items: stretch;
    }
    
    .cart-actions {
        width: 100%;
    }
    
    .cart-actions .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
@endpush
