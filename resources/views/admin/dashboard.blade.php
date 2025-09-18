@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary me-3">
                    <i class="fas fa-cube"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ \App\Models\Product::count() }}</h3>
                    <small class="text-muted">Tổng sản phẩm</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success me-3">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ \App\Models\Order::count() }}</h3>
                    <small class="text-muted">Tổng đơn hàng</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-info me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ \App\Models\User::customers()->count() }}</h3>
                    <small class="text-muted">Khách hàng</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-warning me-3">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ \App\Models\Category::count() }}</h3>
                    <small class="text-muted">Danh mục</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Đơn hàng gần đây
                </h5>
            </div>
            <div class="card-body">
                @php
                    $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                @endphp
                
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>{{ $order->user->full_name ?? $order->user->name }}</td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                        <td>
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
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                            Xem tất cả đơn hàng
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có đơn hàng nào</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
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
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Thêm sản phẩm mới
                    </a>
                    
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Thêm danh mục mới
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="btn btn-info">
                        <i class="fas fa-list me-2"></i>
                        Quản lý sản phẩm
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-warning">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Quản lý đơn hàng
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0 text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cảnh báo tồn kho
                </h5>
            </div>
            <div class="card-body">
                @php
                    $lowStockProducts = \App\Models\Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->take(5)->get();
                @endphp
                
                @if($lowStockProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($lowStockProducts as $product)
                            <div class="list-group-item px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($product->name, 30) }}</h6>
                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                    </div>
                                    <span class="badge bg-danger">{{ $product->stock_quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.products.index') }}?stock_alert=1" class="btn btn-outline-danger btn-sm">
                            Xem tất cả
                        </a>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-muted mb-0">Tất cả sản phẩm đều có đủ tồn kho</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="row">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">Chào mừng trở lại, {{ Auth::user()->full_name ?? Auth::user()->name }}!</h4>
                        <p class="mb-0">Hôm nay là {{ now()->format('l, d/m/Y') }}. Hãy bắt đầu quản lý cửa hàng của bạn.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card:hover .stats-icon {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush
