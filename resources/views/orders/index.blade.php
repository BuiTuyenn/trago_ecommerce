@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-shopping-bag me-2"></i>
                    Đơn hàng của tôi
                </h2>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-1"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($orders as $order)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h6 class="mb-0">
                                        <i class="fas fa-hashtag me-1"></i>
                                        {{ $order->order_number }}
                                    </h6>
                                    <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="col-md-2">
                                    <strong class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                </div>
                                <div class="col-md-2">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">Đang xử lý</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-primary">Đã gửi</span>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success">Đã giao</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                    @endswitch
                                </div>
                                <div class="col-md-2">
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
                                <div class="col-md-3 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>
                                        @if(in_array($order->status, ['pending', 'processing']))
                                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                                    onclick="cancelOrder({{ $order->id }})">
                                                <i class="fas fa-times"></i> Hủy
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($order->orderItems->take(3) as $item)
                                    <div class="col-lg-4 col-md-6 mb-3">
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
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ Str::limit($item->product_name, 25) }}</h6>
                                                <small class="text-muted">
                                                    {{ number_format($item->unit_price, 0, ',', '.') }}₫ × {{ $item->quantity }}
                                                </small>
                                                <div class="fw-bold text-primary">{{ number_format($item->total_price, 0, ',', '.') }}₫</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($order->orderItems->count() > 3)
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <div class="text-center text-muted">
                                                <i class="fas fa-ellipsis-h fa-2x mb-2"></i>
                                                <div>+{{ $order->orderItems->count() - 3 }} sản phẩm khác</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Order Progress -->
                            @if($order->status !== 'cancelled')
                                <div class="order-progress mt-4">
                                    <div class="progress" style="height: 4px;">
                                        @php
                                            $progress = 0;
                                            switch($order->status) {
                                                case 'pending': $progress = 25; break;
                                                case 'processing': $progress = 50; break;
                                                case 'shipped': $progress = 75; break;
                                                case 'delivered': $progress = 100; break;
                                            }
                                        @endphp
                                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-{{ $order->status === 'pending' ? 'primary' : 'muted' }}">
                                            <i class="fas fa-check-circle"></i> Đặt hàng
                                        </small>
                                        <small class="text-{{ $order->status === 'processing' ? 'primary' : 'muted' }}">
                                            <i class="fas fa-cog"></i> Xử lý
                                        </small>
                                        <small class="text-{{ $order->status === 'shipped' ? 'primary' : 'muted' }}">
                                            <i class="fas fa-shipping-fast"></i> Vận chuyển
                                        </small>
                                        <small class="text-{{ $order->status === 'delivered' ? 'primary' : 'muted' }}">
                                            <i class="fas fa-home"></i> Giao hàng
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-bag fa-5x text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Bạn chưa có đơn hàng nào</h3>
                        <p class="text-muted mb-4">Hãy khám phá các sản phẩm tuyệt vời và đặt hàng ngay!</p>
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

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Hành động này không thể hoàn tác.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                <form id="cancel-order-form" method="POST" class="d-inline">
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
    const form = document.getElementById('cancel-order-form');
    form.action = `/orders/${orderId}/cancel`;
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.order-progress .progress-bar {
    background-color: #28a745;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 12px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0 !important;
}

.btn-group .btn {
    border-radius: 6px;
}

.btn-group .btn:not(:last-child) {
    margin-right: 5px;
}

@media (max-width: 768px) {
    .card-header .row > div {
        margin-bottom: 10px;
    }
    
    .card-header .row > div:last-child {
        text-align: center !important;
    }
}
</style>
@endpush
