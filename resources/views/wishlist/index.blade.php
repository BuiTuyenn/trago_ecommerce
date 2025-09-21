@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách yêu thích</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-heart text-danger me-2"></i>
                    Danh sách yêu thích
                </h2>
                <span class="badge bg-primary fs-6">{{ $wishlistItems->total() }} sản phẩm</span>
            </div>
        </div>
    </div>

    @if($wishlistItems->count() > 0)
        <div class="row">
            @foreach($wishlistItems as $item)
                @if($item->product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4" id="wishlist-item-{{ $item->id }}">
                        <div class="card h-100 shadow-sm product-card">
                            <!-- Product Image -->
                            <div class="position-relative">
                                @if($item->product->image)
                                    <img src="{{ asset('images/' . $item->product->image) }}" 
                                         class="card-img-top" alt="{{ $item->product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Remove from wishlist button -->
                                <button class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 remove-wishlist-btn"
                                        data-product-id="{{ $item->product->id }}"
                                        title="Xóa khỏi danh sách yêu thích">
                                    <i class="fas fa-times"></i>
                                </button>

                                <!-- Stock status -->
                                @if(!$item->product->in_stock)
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-secondary">Hết hàng</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Product Name -->
                                <h6 class="card-title mb-2">
                                    <a href="{{ route('products.show', $item->product->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $item->product->name }}
                                    </a>
                                </h6>

                                <!-- Category -->
                                @if($item->product->category)
                                    <small class="text-muted mb-2">
                                        {{ $item->product->category->name }}
                                    </small>
                                @endif

                                <!-- Rating -->
                                @if($item->product->reviews->count() > 0)
                                    <div class="rating mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="stars me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $item->product->average_rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <small class="text-muted">({{ $item->product->reviews->count() }})</small>
                                        </div>
                                    </div>
                                @endif

                                <!-- Price -->
                                <div class="price mb-3">
                                    @if($item->product->sale_price)
                                        <span class="h6 text-danger fw-bold">{{ number_format($item->product->sale_price) }}₫</span>
                                        <span class="text-muted text-decoration-line-through ms-2">{{ number_format($item->product->price) }}₫</span>
                                    @else
                                        <span class="h6 text-danger fw-bold">{{ number_format($item->product->price) }}₫</span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-auto">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.show', $item->product->slug) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                                        </a>
                                        @if($item->product->in_stock)
                                            <button class="btn btn-primary btn-sm add-to-cart-btn" 
                                                    data-product-id="{{ $item->product->id }}">
                                                <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                            </button>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-times me-1"></i>Hết hàng
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Added date -->
                                <small class="text-muted mt-2">
                                    Đã thêm: {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        @if($wishlistItems->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $wishlistItems->links() }}
            </div>
        @endif
    @else
        <!-- Empty wishlist -->
        <div class="text-center py-5">
            <i class="fas fa-heart fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">Danh sách yêu thích trống</h4>
            <p class="text-muted">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Khám phá sản phẩm
            </a>
        </div>
    @endif
</div>

<!-- JavaScript for wishlist interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist
    document.querySelectorAll('.remove-wishlist-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            if (confirm('Bạn có muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
                removeFromWishlist(productId);
            }
        });
    });

    // Add to cart from wishlist
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            addToCart(productId);
        });
    });
});

function removeFromWishlist(productId) {
    fetch('/wishlist/remove', {
        method: 'DELETE',
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
            // Remove the item from DOM
            const item = document.querySelector(`#wishlist-item-${productId}`);
            if (item) {
                item.remove();
            }
            
            // Show success message
            showAlert('success', data.message);
            
            // Refresh page if no items left
            if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            showAlert('error', data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Có lỗi xảy ra khi xóa sản phẩm');
    });
}

function addToCart(productId) {
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
            showAlert('success', 'Đã thêm sản phẩm vào giỏ hàng!');
            
            // Update cart count if cart count element exists
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.cart_count) {
                cartCount.textContent = data.cart_count;
            }
        } else {
            showAlert('error', data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Có lỗi xảy ra khi thêm vào giỏ hàng');
    });
}

function showAlert(type, message) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>

<style>
.product-card {
    transition: transform 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px);
}

.stars i {
    font-size: 0.8rem;
}

.remove-wishlist-btn {
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-wishlist-btn:hover {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}
</style>
@endsection
