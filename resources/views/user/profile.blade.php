@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang cá nhân</a></li>
                    <li class="breadcrumb-item active">Thông tin cá nhân</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-user me-2"></i>
                    Thông tin cá nhân
                </h2>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i>Chỉnh sửa
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Info -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="Avatar" class="rounded-circle mb-3" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    @endif
                    
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    @if($user->phone)
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            {{ $user->phone }}
                        </p>
                    @endif
                    
                    <p class="mb-0">
                        <i class="fas fa-calendar me-2"></i>
                        Tham gia: {{ $user->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Thống kê</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary mb-0">{{ $stats['total_orders'] }}</h4>
                            <small class="text-muted">Đơn hàng</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-0">{{ $stats['total_reviews'] }}</h4>
                            <small class="text-muted">Đánh giá</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $stats['completed_orders'] }}</h4>
                            <small class="text-muted">Hoàn thành</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-danger mb-0">{{ $stats['wishlist_items'] }}</h4>
                            <small class="text-muted">Yêu thích</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Info -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chi tiết thông tin</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Tên đầy đủ:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : 'Chưa cập nhật' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->email }}
                            @if($user->hasVerifiedEmail())
                                <span class="badge bg-success ms-2">Đã xác thực</span>
                            @else
                                <span class="badge bg-warning ms-2">Chưa xác thực</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Số điện thoại:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->phone ?: 'Chưa cập nhật' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Ngày sinh:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->date_of_birth ? $user->date_of_birth->format('d/m/Y') : 'Chưa cập nhật' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Giới tính:</strong>
                        </div>
                        <div class="col-sm-9">
                            @switch($user->gender)
                                @case('male')
                                    Nam
                                    @break
                                @case('female')
                                    Nữ
                                    @break
                                @case('other')
                                    Khác
                                    @break
                                @default
                                    Chưa cập nhật
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Tài khoản:</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Quản trị viên</span>
                            @else
                                <span class="badge bg-primary">Khách hàng</span>
                            @endif
                            
                            @if($user->is_active)
                                <span class="badge bg-success ms-2">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary ms-2">Bị khóa</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Ngày tham gia:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    
                    @if($user->last_login_at)
                    <div class="row">
                        <div class="col-sm-3">
                            <strong>Lần đăng nhập cuối:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Chỉnh sửa thông tin
                        </a>
                        <a href="{{ route('user.change-password') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-key me-1"></i>Đổi mật khẩu
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-1"></i>Xem đơn hàng
                        </a>
                        <a href="{{ route('user.reviews') }}" class="btn btn-outline-warning">
                            <i class="fas fa-star me-1"></i>Đánh giá của tôi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
