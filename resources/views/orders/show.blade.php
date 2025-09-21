@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Đơn hàng</a></li>
                    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Đơn hàng #{{ $order->order_number }}</h2>
                    <p class="text-muted mb-0">Đặt hàng ngày {{ $order->created_at->format('d/m/Y lúc H:i') }}</p>
                </div>
                <div class="text-end">
                    @switch($order->status)
                        @case('pending')
                            <span class="badge bg-warning fs-6">Chờ xử lý</span>
                            @break
                        @case('processing')
                            <span class="badge bg-info fs-6">Đang xử lý</span>
                            @break
                        @case('shipped')
                            <span class="badge bg-primary fs-6">Đã gửi</span>
                            @break
                        @case('delivered')
                            <span class="badge bg-success fs-6">Đã giao</span>
                            @break
                        @case('cancelled')
                            <span class="badge bg-danger fs-6">Đã hủy</span>
                            @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card mb-4">
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
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 80px; height: 80px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                    <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @if($item->product)
                                                        <br><a href="{{ route('products.show', $item->product->slug) }}" 
                                                               class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i> Xem sản phẩm
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

            <!-- Order Status Timeline -->
            @if($order->status !== 'cancelled')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-truck me-2"></i>
                            Trạng thái đơn hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item {{ $order->status !== 'pending' ? 'completed' : 'active' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đặt hàng thành công</h6>
                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status === 'processing' ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Xác nhận và xử lý</h6>
                                    <small class="text-muted">
                                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                            Đã xử lý
                                        @else
                                            Đang chờ xử lý
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status === 'shipped' ? 'active' : '') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Giao hàng</h6>
                                    <small class="text-muted">
                                        @if($order->shipped_at)
                                            {{ $order->shipped_at->format('d/m/Y H:i') }}
                                        @elseif(in_array($order->status, ['shipped', 'delivered']))
                                            Đã gửi hàng
                                        @else
                                            Chưa gửi hàng
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Giao hàng thành công</h6>
                                    <small class="text-muted">
                                        @if($order->delivered_at)
                                            {{ $order->delivered_at->format('d/m/Y H:i') }}
                                        @else
                                            Chưa giao hàng
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Address Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Thông tin giao hàng & thanh toán
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Địa chỉ giao hàng</h6>
                            <address>
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
                            <h6>Địa chỉ thanh toán</h6>
                            <address>
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
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card mb-4">
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
                    
                    <div class="order-info">
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
                        
                        <div class="mb-3">
                            <strong>Trạng thái thanh toán:</strong><br>
                            @switch($order->payment_status)
                                @case('pending')
                                    <span class="badge bg-secondary">Chờ thanh toán</span>
                                    @break
                                @case('paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                    @break
                                @case('failed')
                                    <span class="badge bg-danger">Thanh toán thất bại</span>
                                    @break
                            @endswitch
                        </div>

                        @if($order->notes)
                            <div class="mb-3">
                                <strong>Ghi chú:</strong><br>
                                <p class="mb-0 text-muted">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>

                    @if(in_array($order->status, ['pending', 'processing']))
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-danger" onclick="cancelOrder({{ $order->id }})">
                                <i class="fas fa-times me-2"></i>
                                Hủy đơn hàng
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Support -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-headset me-2"></i>
                        Cần hỗ trợ?
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào về đơn hàng này.</p>
                    <div class="d-grid gap-2">
                        <a href="tel:1900-1234" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>
                            Gọi: 1900-1234
                        </a>
                        <a href="mailto:support@trego.com" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>
                            Email hỗ trợ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng <strong>#{{ $order->order_number }}</strong> không?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Hành động này không thể hoàn tác. Số lượng sản phẩm sẽ được hoàn lại vào kho.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                <form id="cancel-order-form" method="POST" action="{{ route('orders.cancel', $order) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Có, hủy đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelOrder(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #e9ecef;
    border: 3px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
    color: white;
}

.timeline-item.active .timeline-marker {
    background: #007bff;
    color: white;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-item.completed .timeline-content h6 {
    color: #28a745;
}

.timeline-item.active .timeline-content h6 {
    color: #007bff;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 12px;
}

.badge.fs-6 {
    font-size: 0.875rem !important;
}
</style>
@endpush
