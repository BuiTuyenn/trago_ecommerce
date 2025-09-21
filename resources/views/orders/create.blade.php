@extends('layouts.app')

@section('title', 'Đặt hàng')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active">Đặt hàng</li>
                </ol>
            </nav>
            
            <h2 class="mb-4">
                <i class="fas fa-shopping-cart me-2"></i>
                Đặt hàng
            </h2>
        </div>
    </div>

    <form method="POST" action="{{ route('orders.store') }}" id="checkout-form">
        @csrf
        
        <div class="row">
            <!-- Billing & Shipping Information -->
            <div class="col-lg-8">
                <!-- Shipping Address -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shipping-fast me-2"></i>
                            Thông tin giao hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shipping_first_name') is-invalid @enderror" 
                                       id="shipping_first_name" name="shipping_first_name" 
                                       value="{{ old('shipping_first_name', Auth::user()->first_name) }}" required>
                                @error('shipping_first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shipping_last_name') is-invalid @enderror" 
                                       id="shipping_last_name" name="shipping_last_name" 
                                       value="{{ old('shipping_last_name', Auth::user()->last_name) }}" required>
                                @error('shipping_last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_company" class="form-label">Công ty (tùy chọn)</label>
                            <input type="text" class="form-control @error('shipping_company') is-invalid @enderror" 
                                   id="shipping_company" name="shipping_company" 
                                   value="{{ old('shipping_company') }}">
                            @error('shipping_company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address_1" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shipping_address_1') is-invalid @enderror" 
                                   id="shipping_address_1" name="shipping_address_1" 
                                   value="{{ old('shipping_address_1') }}" 
                                   placeholder="Số nhà, tên đường" required>
                            @error('shipping_address_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address_2" class="form-label">Địa chỉ 2 (tùy chọn)</label>
                            <input type="text" class="form-control @error('shipping_address_2') is-invalid @enderror" 
                                   id="shipping_address_2" name="shipping_address_2" 
                                   value="{{ old('shipping_address_2') }}" 
                                   placeholder="Căn hộ, tầng, tòa nhà">
                            @error('shipping_address_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="shipping_city" class="form-label">Thành phố <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" 
                                       id="shipping_city" name="shipping_city" 
                                       value="{{ old('shipping_city') }}" required>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shipping_state" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select class="form-select @error('shipping_state') is-invalid @enderror" 
                                        id="shipping_state" name="shipping_state" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    <option value="Hà Nội" {{ old('shipping_state') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="TP. Hồ Chí Minh" {{ old('shipping_state') == 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                                    <option value="Đà Nẵng" {{ old('shipping_state') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    <option value="Hải Phòng" {{ old('shipping_state') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                    <option value="Cần Thơ" {{ old('shipping_state') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                    <option value="Khác" {{ old('shipping_state') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('shipping_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shipping_postcode" class="form-label">Mã bưu điện <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shipping_postcode') is-invalid @enderror" 
                                       id="shipping_postcode" name="shipping_postcode" 
                                       value="{{ old('shipping_postcode') }}" required>
                                @error('shipping_postcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_country" class="form-label">Quốc gia <span class="text-danger">*</span></label>
                                <select class="form-select @error('shipping_country') is-invalid @enderror" 
                                        id="shipping_country" name="shipping_country" required>
                                    <option value="Vietnam" {{ old('shipping_country', 'Vietnam') == 'Vietnam' ? 'selected' : '' }}>Việt Nam</option>
                                </select>
                                @error('shipping_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('shipping_phone') is-invalid @enderror" 
                                       id="shipping_phone" name="shipping_phone" 
                                       value="{{ old('shipping_phone', Auth::user()->phone) }}">
                                @error('shipping_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>
                            Thông tin thanh toán
                        </h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="same_as_shipping" checked>
                            <label class="form-check-label" for="same_as_shipping">
                                Giống thông tin giao hàng
                            </label>
                        </div>
                    </div>
                    <div class="card-body" id="billing-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_first_name" class="form-label">Họ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('billing_first_name') is-invalid @enderror" 
                                       id="billing_first_name" name="billing_first_name" 
                                       value="{{ old('billing_first_name', Auth::user()->first_name) }}" required>
                                @error('billing_first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_last_name" class="form-label">Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('billing_last_name') is-invalid @enderror" 
                                       id="billing_last_name" name="billing_last_name" 
                                       value="{{ old('billing_last_name', Auth::user()->last_name) }}" required>
                                @error('billing_last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_company" class="form-label">Công ty (tùy chọn)</label>
                            <input type="text" class="form-control @error('billing_company') is-invalid @enderror" 
                                   id="billing_company" name="billing_company" 
                                   value="{{ old('billing_company') }}">
                            @error('billing_company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_address_1" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('billing_address_1') is-invalid @enderror" 
                                   id="billing_address_1" name="billing_address_1" 
                                   value="{{ old('billing_address_1') }}" 
                                   placeholder="Số nhà, tên đường" required>
                            @error('billing_address_1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_address_2" class="form-label">Địa chỉ 2 (tùy chọn)</label>
                            <input type="text" class="form-control @error('billing_address_2') is-invalid @enderror" 
                                   id="billing_address_2" name="billing_address_2" 
                                   value="{{ old('billing_address_2') }}" 
                                   placeholder="Căn hộ, tầng, tòa nhà">
                            @error('billing_address_2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="billing_city" class="form-label">Thành phố <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('billing_city') is-invalid @enderror" 
                                       id="billing_city" name="billing_city" 
                                       value="{{ old('billing_city') }}" required>
                                @error('billing_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="billing_state" class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select class="form-select @error('billing_state') is-invalid @enderror" 
                                        id="billing_state" name="billing_state" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    <option value="Hà Nội" {{ old('billing_state') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="TP. Hồ Chí Minh" {{ old('billing_state') == 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                                    <option value="Đà Nẵng" {{ old('billing_state') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    <option value="Hải Phòng" {{ old('billing_state') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                    <option value="Cần Thơ" {{ old('billing_state') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                    <option value="Khác" {{ old('billing_state') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('billing_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="billing_postcode" class="form-label">Mã bưu điện <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('billing_postcode') is-invalid @enderror" 
                                       id="billing_postcode" name="billing_postcode" 
                                       value="{{ old('billing_postcode') }}" required>
                                @error('billing_postcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_country" class="form-label">Quốc gia <span class="text-danger">*</span></label>
                                <select class="form-select @error('billing_country') is-invalid @enderror" 
                                        id="billing_country" name="billing_country" required>
                                    <option value="Vietnam" {{ old('billing_country', 'Vietnam') == 'Vietnam' ? 'selected' : '' }}>Việt Nam</option>
                                </select>
                                @error('billing_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('billing_phone') is-invalid @enderror" 
                                       id="billing_phone" name="billing_phone" 
                                       value="{{ old('billing_phone', Auth::user()->phone) }}">
                                @error('billing_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>
                            Phương thức thanh toán
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input @error('payment_method') is-invalid @enderror" 
                                   type="radio" name="payment_method" id="cod" value="cod" 
                                   {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cod">
                                <strong>Thanh toán khi nhận hàng (COD)</strong>
                                <small class="d-block text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input @error('payment_method') is-invalid @enderror" 
                                   type="radio" name="payment_method" id="bank_transfer" value="bank_transfer"
                                   {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="bank_transfer">
                                <strong>Chuyển khoản ngân hàng</strong>
                                <small class="d-block text-muted">Chuyển khoản trước khi giao hàng</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('payment_method') is-invalid @enderror" 
                                   type="radio" name="payment_method" id="credit_card" value="credit_card"
                                   {{ old('payment_method') == 'credit_card' ? 'checked' : '' }}>
                            <label class="form-check-label" for="credit_card">
                                <strong>Thẻ tín dụng/Thẻ ghi nợ</strong>
                                <small class="d-block text-muted">Thanh toán online an toàn</small>
                            </label>
                        </div>
                        @error('payment_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note me-2"></i>
                            Ghi chú đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Ghi chú thêm về đơn hàng (tùy chọn)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card position-sticky" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Tóm tắt đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Cart Items -->
                        <div class="order-items mb-3">
                            @foreach($cartItems as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <div class="flex-shrink-0 me-3">
                                        @if($item->product->image)
                                            <img src="{{ asset('images/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($item->product->name, 30) }}</h6>
                                        <small class="text-muted">{{ number_format($item->unit_price, 0, ',', '.') }}₫ × {{ $item->quantity }}</small>
                                        <div class="fw-bold text-primary">{{ number_format($item->total_price, 0, ',', '.') }}₫</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span class="{{ $shippingCost == 0 ? 'text-success' : '' }}">
                                    {{ $shippingCost == 0 ? 'Miễn phí' : number_format($shippingCost, 0, ',', '.') . '₫' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>VAT (10%):</span>
                                <span>{{ number_format($taxAmount, 0, ',', '.') }}₫</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-primary fs-5">{{ number_format($total, 0, ',', '.') }}₫</strong>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="place-order-btn">
                                <i class="fas fa-lock me-2"></i>
                                Đặt hàng
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Thông tin của bạn được bảo mật an toàn
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle billing address visibility
    $('#same_as_shipping').change(function() {
        if ($(this).is(':checked')) {
            copyShippingToBilling();
            $('#billing-section input, #billing-section select').prop('disabled', true);
        } else {
            $('#billing-section input, #billing-section select').prop('disabled', false);
        }
    });

    // Copy shipping to billing initially if checked
    if ($('#same_as_shipping').is(':checked')) {
        copyShippingToBilling();
        $('#billing-section input, #billing-section select').prop('disabled', true);
    }

    // Copy shipping address when fields change
    $('#shipping_first_name, #shipping_last_name, #shipping_company, #shipping_address_1, #shipping_address_2, #shipping_city, #shipping_state, #shipping_postcode, #shipping_country, #shipping_phone').on('input change', function() {
        if ($('#same_as_shipping').is(':checked')) {
            copyShippingToBilling();
        }
    });

    function copyShippingToBilling() {
        $('#billing_first_name').val($('#shipping_first_name').val());
        $('#billing_last_name').val($('#shipping_last_name').val());
        $('#billing_company').val($('#shipping_company').val());
        $('#billing_address_1').val($('#shipping_address_1').val());
        $('#billing_address_2').val($('#shipping_address_2').val());
        $('#billing_city').val($('#shipping_city').val());
        $('#billing_state').val($('#shipping_state').val());
        $('#billing_postcode').val($('#shipping_postcode').val());
        $('#billing_country').val($('#shipping_country').val());
        $('#billing_phone').val($('#shipping_phone').val());
    }

    // Form submission
    $('#checkout-form').submit(function() {
        $('#place-order-btn').prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...');
    });
});
</script>
@endpush

@push('styles')
<style>
.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.order-items {
    max-height: 300px;
    overflow-y: auto;
}

.card.position-sticky {
    max-height: calc(100vh - 40px);
    overflow-y: auto;
}

@media (max-width: 991px) {
    .card.position-sticky {
        position: static !important;
        max-height: none;
    }
}
</style>
@endpush
