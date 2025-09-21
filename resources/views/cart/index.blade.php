@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng của bạn</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>

    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Thành tiền</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr data-item-id="{{ $item->id }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image me-3">
                                                        @if($item->product->image)
                                                            <img src="{{ asset('images/' . $item->product->image) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 80px; height: 80px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('products.show', $item->product->slug) }}" 
                                                               class="text-decoration-none text-dark">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                        @if($item->product->stock_quantity <= 5)
                                                            <br><small class="text-warning">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                                Chỉ còn {{ $item->product->stock_quantity }} sản phẩm
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="fw-bold text-primary">
                                                    {{ number_format($item->unit_price, 0, ',', '.') }}₫
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="quantity-controls d-flex justify-content-center align-items-center">
                                                    <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                            data-action="decrease" 
                                                            data-item-id="{{ $item->id }}"
                                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center mx-2 quantity-input" 
                                                           style="width: 70px;"
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock_quantity }}"
                                                           data-item-id="{{ $item->id }}">
                                                    <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                            data-action="increase" 
                                                            data-item-id="{{ $item->id }}"
                                                            {{ $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="fw-bold item-total" data-item-id="{{ $item->id }}">
                                                    {{ number_format($item->total_price, 0, ',', '.') }}₫
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-outline-danger btn-sm remove-item" 
                                                        data-item-id="{{ $item->id }}"
                                                        title="Xóa sản phẩm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cart Actions -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button class="btn btn-outline-warning" id="clear-cart">
                        <i class="fas fa-trash-alt me-1"></i>
                        Xóa tất cả
                    </button>
                    <div>
                        <span class="text-muted me-3">
                            Tổng cộng: <strong id="cart-total">{{ number_format($total, 0, ',', '.') }}₫</strong>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Tóm tắt đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <span id="subtotal">{{ number_format($total, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-primary" id="final-total">{{ number_format($total, 0, ',', '.') }}₫</strong>
                        </div>
                        
                        @auth
                            <div class="d-grid">
                                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Tiến hành thanh toán
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập</a> 
                                để tiến hành thanh toán
                            </div>
                        @endauth

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Thanh toán an toàn & bảo mật
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Promotion Code -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-tag me-2"></i>
                            Mã giảm giá
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá">
                            <button class="btn btn-outline-primary" type="button">
                                Áp dụng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Giỏ hàng của bạn đang trống</h3>
                        <p class="text-muted mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-1"></i>
                                Về trang chủ
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-search me-1"></i>
                                Xem sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Quantity increase/decrease buttons
    $('.quantity-btn').click(function() {
        const action = $(this).data('action');
        const itemId = $(this).data('item-id');
        const quantityInput = $(`.quantity-input[data-item-id="${itemId}"]`);
        let currentQuantity = parseInt(quantityInput.val());
        const maxQuantity = parseInt(quantityInput.attr('max'));

        if (action === 'increase' && currentQuantity < maxQuantity) {
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }

        quantityInput.val(currentQuantity);
        updateCartItem(itemId, currentQuantity);
    });

    // Direct quantity input change
    $('.quantity-input').on('change', function() {
        const itemId = $(this).data('item-id');
        const quantity = parseInt($(this).val());
        const maxQuantity = parseInt($(this).attr('max'));

        if (quantity > maxQuantity) {
            $(this).val(maxQuantity);
            updateCartItem(itemId, maxQuantity);
        } else if (quantity < 1) {
            $(this).val(1);
            updateCartItem(itemId, 1);
        } else {
            updateCartItem(itemId, quantity);
        }
    });

    // Remove item
    $('.remove-item').click(function() {
        const itemId = $(this).data('item-id');
        if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            removeCartItem(itemId);
        }
    });

    // Clear cart
    $('#clear-cart').click(function() {
        if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
            clearCart();
        }
    });

    function updateCartItem(itemId, quantity) {
        $.ajax({
            url: `/cart/update/${itemId}`,
            type: 'PUT',
            data: { quantity: quantity },
            success: function(response) {
                if (response.success) {
                    // Update item total
                    $(`.item-total[data-item-id="${itemId}"]`).text(formatNumber(response.item_total) + '₫');
                    
                    // Update cart totals
                    updateCartTotals(response.cart_total);
                    
                    // Update quantity controls
                    updateQuantityControls(itemId, quantity);
                    
                    showAlert('success', 'Đã cập nhật giỏ hàng');
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng');
            }
        });
    }

    function removeCartItem(itemId) {
        $.ajax({
            url: `/cart/remove/${itemId}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    // Remove item row
                    $(`tr[data-item-id="${itemId}"]`).fadeOut(function() {
                        $(this).remove();
                        
                        // Check if cart is empty
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        } else {
                            updateCartTotals(response.cart_total);
                        }
                    });
                    
                    // Update cart count in header
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                    
                    showAlert('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'Có lỗi xảy ra khi xóa sản phẩm');
            }
        });
    }

    function clearCart() {
        $.ajax({
            url: '/cart/clear',
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'Có lỗi xảy ra khi xóa giỏ hàng');
            }
        });
    }

    function updateCartTotals(total) {
        const formattedTotal = formatNumber(total) + '₫';
        $('#cart-total').text(formattedTotal);
        $('#subtotal').text(formattedTotal);
        $('#final-total').text(formattedTotal);
    }

    function updateQuantityControls(itemId, quantity) {
        const decreaseBtn = $(`.quantity-btn[data-action="decrease"][data-item-id="${itemId}"]`);
        const increaseBtn = $(`.quantity-btn[data-action="increase"][data-item-id="${itemId}"]`);
        const quantityInput = $(`.quantity-input[data-item-id="${itemId}"]`);
        const maxQuantity = parseInt(quantityInput.attr('max'));

        // Update button states
        decreaseBtn.prop('disabled', quantity <= 1);
        increaseBtn.prop('disabled', quantity >= maxQuantity);
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

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
.quantity-controls .btn {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-input {
    border: 1px solid #dee2e6;
    text-align: center;
}

.product-image img,
.product-image .bg-light {
    border-radius: 8px;
}

.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.btn-lg {
    padding: 12px 24px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .table-responsive table {
        font-size: 14px;
    }
    
    .quantity-controls {
        flex-direction: column;
        gap: 5px;
    }
    
    .quantity-controls .btn {
        width: 30px;
        height: 30px;
    }
    
    .quantity-input {
        width: 60px !important;
    }
}
</style>
@endpush
