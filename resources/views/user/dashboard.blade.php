@extends('layouts.app')

@section('title', 'Trang cá nhân')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Trang cá nhân</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-user-circle me-2"></i>
                    Xin chào, {{ $user->name }}!
                </h2>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>Chỉnh sửa hồ sơ
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-bag fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3 text-end">
                            <h3 class="mb-0">{{ $stats['total_orders'] }}</h3>
                            <small>Tổng đơn hàng</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3 text-end">
                            <h3 class="mb-0">{{ $stats['completed_orders'] }}</h3>
                            <small>Đã hoàn thành</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3 text-end">
                            <h3 class="mb-0">{{ $stats['total_reviews'] }}</h3>
                            <small>Đánh giá</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3 text-end">
                            <h3 class="mb-0">{{ $stats['wishlist_items'] }}</h3>
                            <small>Yêu thích</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Xem đơn hàng
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-heart me-2"></i>Danh sách yêu thích
                        </a>
                        <a href="{{ route('user.reviews') }}" class="btn btn-outline-warning">
                            <i class="fas fa-star me-2"></i>Đánh giá của tôi
                        </a>
                        <a href="{{ route('user.browse-history') }}" class="btn btn-outline-info">
                            <i class="fas fa-history me-2"></i>Lịch sử duyệt
                        </a>
                        <a href="{{ route('user.change-password') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-key me-2"></i>Đổi mật khẩu
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            @if($stats['total_spent'] > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-wallet me-2"></i>
                        Thống kê chi tiêu
                    </h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="text-success">{{ number_format($stats['total_spent']) }}₫</h3>
                    <small class="text-muted">Tổng chi tiêu</small>
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Đơn hàng gần đây
                    </h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    @forelse($recentOrders as $order)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <strong>{{ $order->order_number }}</strong>
                                <br>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="text-center">
                                <div>{{ number_format($order->total_amount) }}₫</div>
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
                            <div>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có đơn hàng nào</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Browse History -->
    @if($browseHistory->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Sản phẩm đã xem gần đây
                    </h5>
                    <a href="{{ route('user.browse-history') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($browseHistory->take(6) as $item)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                                <div class="card h-100">
                                    @if($item->product_image)
                                        <img src="{{ asset('images/' . $item->product_image) }}" 
                                             class="card-img-top" alt="{{ $item->product_name }}"
                                             style="height: 120px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 120px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <h6 class="card-title small mb-1">{{ Str::limit($item->product_name, 30) }}</h6>
                                        <small class="text-danger fw-bold">{{ number_format($item->product_price) }}₫</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
