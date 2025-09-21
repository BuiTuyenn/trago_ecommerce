@extends('layouts.app')

@section('title', 'Xác thực email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-envelope-check me-2"></i>
                        Xác thực email
                    </h4>
                </div>
                <div class="card-body p-4 text-center">
                    {{-- Session messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Một link xác thực mới đã được gửi đến địa chỉ email bạn đã cung cấp khi đăng ký.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="mb-4">
                        <i class="fas fa-envelope fa-5x text-info mb-3"></i>
                        <h5 class="text-dark">Kiểm tra email của bạn</h5>
                    </div>

                    <p class="text-muted mb-4">
                        Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, bạn có thể xác thực địa chỉ email của mình bằng cách 
                        nhấp vào liên kết chúng tôi vừa gửi qua email cho bạn? Nếu bạn không nhận được email, 
                        chúng tôi sẽ sẵn lòng gửi cho bạn một email khác.
                    </p>

                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                Gửi lại email xác thực
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="text-dark mb-2">
                            <i class="fas fa-lightbulb me-2"></i>
                            Lưu ý quan trọng
                        </h6>
                        <ul class="text-muted text-start mb-0" style="font-size: 14px;">
                            <li>Kiểm tra cả hộp thư spam/junk mail</li>
                            <li>Email được gửi từ: <strong>{{ config('mail.from.address') }}</strong></li>
                            <li>Link xác thực có hiệu lực trong 60 phút</li>
                            <li>Nếu vẫn không nhận được, hãy liên hệ hỗ trợ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.btn {
    border-radius: 8px;
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>
@endpush
