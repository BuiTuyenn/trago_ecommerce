@extends('layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang cá nhân</a></li>
                    <li class="breadcrumb-item active">Đổi mật khẩu</li>
                </ol>
            </nav>
            
            <h2 class="mb-4">
                <i class="fas fa-key me-2"></i>
                Đổi mật khẩu
            </h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2"></i>
                        Cập nhật mật khẩu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Mật khẩu mới phải có ít nhất 8 ký tự và bao gồm chữ cái, số.
                    </div>

                    <form method="POST" action="{{ route('user.update-password') }}">
                        @csrf
                        @method('PUT')

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <strong>Mật khẩu hiện tại <span class="text-danger">*</span></strong>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required
                                       placeholder="Nhập mật khẩu hiện tại">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <strong>Mật khẩu mới <span class="text-danger">*</span></strong>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       placeholder="Nhập mật khẩu mới">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password_icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mật khẩu phải có ít nhất 8 ký tự</small>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <strong>Xác nhận mật khẩu mới <span class="text-danger">*</span></strong>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       minlength="8"
                                       placeholder="Nhập lại mật khẩu mới">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mb-4">
                            <div class="password-strength">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="password-strength-text" class="text-muted">Độ mạnh mật khẩu</small>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Cập nhật mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Mẹo bảo mật
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Sử dụng mật khẩu mạnh với ít nhất 8 ký tự</li>
                        <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                        <li>Không sử dụng thông tin cá nhân như tên, ngày sinh</li>
                        <li>Không chia sẻ mật khẩu với người khác</li>
                        <li>Thay đổi mật khẩu định kỳ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    
    passwordField.addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        
        // Update progress bar
        strengthBar.style.width = strength.percentage + '%';
        strengthBar.className = 'progress-bar ' + strength.class;
        strengthText.textContent = strength.text;
        strengthText.className = 'text-' + strength.color;
    });
    
    // Check password confirmation match
    confirmField.addEventListener('input', function() {
        const password = passwordField.value;
        const confirm = this.value;
        
        if (confirm && password !== confirm) {
            this.setCustomValidity('Mật khẩu xác nhận không khớp');
        } else {
            this.setCustomValidity('');
        }
    });
    
    function checkPasswordStrength(password) {
        let score = 0;
        let feedback = [];
        
        if (password.length >= 8) score += 1;
        else feedback.push('Cần ít nhất 8 ký tự');
        
        if (/[a-z]/.test(password)) score += 1;
        else feedback.push('Cần chữ thường');
        
        if (/[A-Z]/.test(password)) score += 1;
        else feedback.push('Cần chữ hoa');
        
        if (/[0-9]/.test(password)) score += 1;
        else feedback.push('Cần số');
        
        if (/[^A-Za-z0-9]/.test(password)) score += 1;
        else feedback.push('Cần ký tự đặc biệt');
        
        const strength = {
            0: { percentage: 0, class: '', text: 'Rất yếu', color: 'muted' },
            1: { percentage: 20, class: 'bg-danger', text: 'Yếu', color: 'danger' },
            2: { percentage: 40, class: 'bg-warning', text: 'Trung bình', color: 'warning' },
            3: { percentage: 60, class: 'bg-info', text: 'Khá', color: 'info' },
            4: { percentage: 80, class: 'bg-primary', text: 'Mạnh', color: 'primary' },
            5: { percentage: 100, class: 'bg-success', text: 'Rất mạnh', color: 'success' }
        };
        
        return strength[score] || strength[0];
    }
});
</script>
@endsection
