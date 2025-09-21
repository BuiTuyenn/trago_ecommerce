@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')
@section('page-title', 'Chi tiết người dùng')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Thông tin cơ bản
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                </div>
                
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tên hiển thị:</strong></td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    @if($user->full_name && $user->full_name !== $user->name)
                    <tr>
                        <td><strong>Họ tên đầy đủ:</strong></td>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @if($user->phone)
                    <tr>
                        <td><strong>Điện thoại:</strong></td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Quyền:</strong></td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">Customer</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Trạng thái:</strong></td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Đã khóa</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Đăng ký:</strong></td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($user->last_login_at)
                    <tr>
                        <td><strong>Đăng nhập cuối:</strong></td>
                        <td>{{ $user->last_login_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
                
                @if($user->id !== Auth::id())
                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} w-100"
                                onclick="return confirm('Bạn có chắc muốn {{ $user->is_active ? 'khóa' : 'kích hoạt' }} tài khoản này?')">
                            <i class="fas fa-{{ $user->is_active ? 'lock' : 'unlock' }} me-1"></i>
                            {{ $user->is_active ? 'Khóa tài khoản' : 'Kích hoạt tài khoản' }}
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-shopping-cart fa-2x"></i>
                            </div>
                            <div>
                                <h5>{{ $user->orders->count() }}</h5>
                                <small>Tổng đơn hàng</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-star fa-2x"></i>
                            </div>
                            <div>
                                <h5>{{ $user->reviews->count() }}</h5>
                                <small>Đánh giá đã viết</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Đơn hàng gần đây
                </h5>
            </div>
            <div class="card-body">
                @if($user->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders->take(10) as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
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
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Người dùng chưa có đơn hàng nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar-lg {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
</style>
@endpush
