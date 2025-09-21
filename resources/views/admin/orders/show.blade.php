@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
            <p class="text-muted">Đặt hàng ngày {{ $order->created_at->format('d/m/Y lúc H:i') }}</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>
                In đơn hàng
            </button>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-info" target="_blank">
                <i class="fas fa-external-link-alt me-1"></i>
                Xem như khách hàng
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Status & Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2"></i>
                        Trạng thái & Thao tác
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Order Status -->
                    <div class="mb-3">
                        <label class="form-label">Trạng thái đơn hàng</label>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select status-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đã gửi</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </form>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-3">
                        <label class="form-label">Trạng thái thanh toán</label>
                        <form method="POST" action="{{ route('admin.orders.update-payment', $order) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <select name="payment_status" class="form-select payment-select">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Thất bại</option>
                            </select>
                        </form>
                    </div>

                    <!-- Timestamps -->
                    <div class="border-top pt-3">
                        <div class="row text-sm">
                            <div class="col-12 mb-2">
                                <strong>Đặt hàng:</strong><br>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i:s') }}</small>
                            </div>
                            @if($order->shipped_at)
                                <div class="col-12 mb-2">
                                    <strong>Gửi hàng:</strong><br>
                                    <small class="text-muted">{{ $order->shipped_at->format('d/m/Y H:i:s') }}</small>
                                </div>
                            @endif
                            @if($order->delivered_at)
                                <div class="col-12 mb-2">
                                    <strong>Giao hàng:</strong><br>
                                    <small class="text-muted">{{ $order->delivered_at->format('d/m/Y H:i:s') }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $order->user->name }}</h6>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Tổng đơn hàng:</small><br>
                            <strong>{{ $order->user->orders()->count() }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Khách hàng từ:</small><br>
                            <strong>{{ $order->user->created_at->format('m/Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Tóm tắt đơn hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span class="{{ $order->shipping_cost == 0 ? 'text-success' : '' }}">
                            {{ $order->shipping_cost == 0 ? 'Miễn phí' : number_format($order->shipping_cost, 0, ',', '.') . '₫' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>VAT:</span>
                        <span>{{ number_format($order->tax_amount, 0, ',', '.') }}₫</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-primary fs-5">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Phương thức thanh toán:</strong><br>
                        @switch($order->payment_method)
                            @case('cod')
                                <span class="badge bg-warning">Thanh toán khi nhận hàng</span>
                                @break
                            @case('bank_transfer')
                                <span class="badge bg-info">Chuyển khoản ngân hàng</span>
                                @break
                            @case('credit_card')
                                <span class="badge bg-success">Thẻ tín dụng</span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Sản phẩm đã đặt ({{ $order->orderItems->count() }} sản phẩm)
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('images/' . $item->product->image) }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="img-thumbnail" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                    <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @if($item->product)
                                                        <br><a href="{{ route('admin.products.show', $item->product) }}" 
                                                               class="btn btn-outline-primary btn-sm" target="_blank">
                                                            <i class="fas fa-external-link-alt"></i> Xem sản phẩm
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="fw-bold">{{ number_format($item->unit_price, 0, ',', '.') }}₫</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="fw-bold text-primary">{{ number_format($item->total_price, 0, ',', '.') }}₫</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping & Billing Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Thông tin giao hàng & thanh toán
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-shipping-fast me-1"></i>
                                Địa chỉ giao hàng
                            </h6>
                            <address class="mb-0">
                                <strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong><br>
                                @if($order->shipping_company)
                                    {{ $order->shipping_company }}<br>
                                @endif
                                {{ $order->shipping_address_1 }}<br>
                                @if($order->shipping_address_2)
                                    {{ $order->shipping_address_2 }}<br>
                                @endif
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postcode }}<br>
                                {{ $order->shipping_country }}<br>
                                @if($order->shipping_phone)
                                    <i class="fas fa-phone me-1"></i>{{ $order->shipping_phone }}
                                @endif
                            </address>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-credit-card me-1"></i>
                                Địa chỉ thanh toán
                            </h6>
                            <address class="mb-0">
                                <strong>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</strong><br>
                                @if($order->billing_company)
                                    {{ $order->billing_company }}<br>
                                @endif
                                {{ $order->billing_address_1 }}<br>
                                @if($order->billing_address_2)
                                    {{ $order->billing_address_2 }}<br>
                                @endif
                                {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postcode }}<br>
                                {{ $order->billing_country }}<br>
                                @if($order->billing_phone)
                                    <i class="fas fa-phone me-1"></i>{{ $order->billing_phone }}
                                @endif
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note me-2"></i>
                            Ghi chú đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit when status changes
    $('.status-select').change(function() {
        if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng này?')) {
            $(this).closest('form').submit();
        } else {
            // Reset to original value if cancelled
            $(this).val($(this).data('original-value'));
        }
    });

    // Auto-submit when payment status changes
    $('.payment-select').change(function() {
        if (confirm('Bạn có chắc chắn muốn thay đổi trạng thái thanh toán?')) {
            $(this).closest('form').submit();
        } else {
            // Reset to original value if cancelled
            $(this).val($(this).data('original-value'));
        }
    });

    // Store original values
    $('.status-select, .payment-select').each(function() {
        $(this).data('original-value', $(this).val());
    });
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    border-radius: 12px;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.status-select, .payment-select {
    cursor: pointer;
}

.status-select:focus, .payment-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

address {
    line-height: 1.6;
}

@media print {
    .btn, .card-header .btn, .form-select {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
