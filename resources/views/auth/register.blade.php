@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        Đăng ký tài khoản
                    </h4>
                </div>
                <div class="card-body p-4">
                    {{-- Kiểm tra session messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i>
                                Tên hiển thị <span class="text-danger">*</span>
                            </label>
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Nhập tên hiển thị">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email"
                                   placeholder="Nhập địa chỉ email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Mật khẩu <span class="text-danger">*</span>
                            </label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                Xác nhận mật khẩu <span class="text-danger">*</span>
                            </label>
                            <input id="password-confirm" type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Nhập lại mật khẩu">
                        </div>

                        <div class="mb-3 p-3 bg-light rounded">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-envelope me-2"></i>
                                Sau khi đăng ký thành công
                            </h6>
                            <small class="text-muted">
                                📧 Bạn sẽ nhận được 2 email:<br>
                                • <strong>Email xác thực tài khoản</strong> - Vui lòng click link để kích hoạt<br>
                                • <strong>Email chào mừng</strong> - Hướng dẫn sử dụng và ưu đãi đặc biệt
                            </small>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus me-2"></i>
                                Đăng ký ngay
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">
                                Đã có tài khoản? 
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    Đăng nhập ngay
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
