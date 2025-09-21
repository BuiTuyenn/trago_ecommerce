@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Quản lý đơn hàng</h1>
            <p class="text-muted">Quản lý và theo dõi tất cả đơn hàng</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-1"></i>
                In báo cáo
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Quay lại Dashboard
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-bag text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ number_format($statistics['total_orders']) }}</h5>
                            <p class="card-text text-muted mb-0">Tổng đơn hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clock text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ number_format($statistics['pending_orders']) }}</h5>
                            <p class="card-text text-muted mb-0">Chờ xử lý</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-dollar-sign text-success fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ number_format($statistics['total_revenue'], 0, ',', '.') }}₫</h5>
                            <p class="card-text text-muted mb-0">Tổng doanh thu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-day text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">{{ number_format($statistics['today_orders']) }}</h5>
                            <p class="card-text text-muted mb-0">Hôm nay</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Mã đơn hàng, tên khách hàng...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái đơn hàng</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Đã gửi</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment_status" class="form-label">Trạng thái thanh toán</label>
                    <select class="form-select" id="payment_status" name="payment_status">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            Lọc
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Xóa bộ lọc
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Danh sách đơn hàng ({{ $orders->total() }} đơn hàng)
            </h5>
        </div>
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                        <br><small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->user->name }}</strong>
                                            <br><small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <strong class="text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                        <br><small class="text-muted">{{ $order->orderItems->count() }} sản phẩm</small>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm status-select" 
                                                    data-order-id="{{ $order->id }}" 
                                                    style="min-width: 130px;">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đã gửi</option>
                                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.orders.update-payment', $order) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="payment_status" class="form-select form-select-sm payment-select" 
                                                    data-order-id="{{ $order->id }}" 
                                                    style="min-width: 120px;">
                                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Thất bại</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn btn-outline-primary btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('orders.show', $order) }}" 
                                               class="btn btn-outline-info btn-sm" title="Xem như khách hàng" target="_blank">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="card-footer">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Không có đơn hàng nào</h5>
                    <p class="text-muted">Chưa có đơn hàng nào được tạo hoặc không có kết quả phù hợp với bộ lọc.</p>
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

.btn-group .btn {
    border-radius: 6px;
}

.btn-group .btn:not(:last-child) {
    margin-right: 2px;
}

.status-select, .payment-select {
    cursor: pointer;
}

.status-select:focus, .payment-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

@media print {
    .btn, .card-header, .pagination {
        display: none !important;
    }
}
</style>
@endpush
