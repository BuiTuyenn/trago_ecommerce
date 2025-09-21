@extends('layouts.app')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Trang cá nhân</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Thông tin cá nhân</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </nav>
            
            <h2 class="mb-4">
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa thông tin cá nhân
            </h2>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar -->
                        <div class="text-center mb-4">
                            <div class="avatar-upload">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="Avatar" id="avatar-preview" 
                                         class="rounded-circle mb-3" 
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                         id="avatar-placeholder"
                                         style="width: 120px; height: 120px;">
                                        <i class="fas fa-user fa-3x text-white"></i>
                                    </div>
                                @endif
                                
                                <div>
                                    <label for="avatar" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-camera me-1"></i>Thay đổi ảnh đại diện
                                    </label>
                                    <input type="file" class="d-none @error('avatar') is-invalid @enderror" 
                                           id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Display Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <strong>Tên hiển thị <span class="text-danger">*</span></strong>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- First Name & Last Name -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">
                                    <strong>Họ</strong>
                                </label>
                                <input type="text" 
                                       class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name', $user->first_name) }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">
                                    <strong>Tên</strong>
                                </label>
                                <input type="text" 
                                       class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name', $user->last_name) }}">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <strong>Số điện thoại</strong>
                            </label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="Ví dụ: 0123456789">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date of Birth & Gender -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">
                                    <strong>Ngày sinh</strong>
                                </label>
                                <input type="date" 
                                       class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">
                                    <strong>Giới tính</strong>
                                </label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" 
                                        name="gender">
                                    <option value="">Chọn giới tính</option>
                                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email (Read Only) -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <strong>Email</strong>
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="{{ $user->email }}" 
                                   readonly>
                            <small class="text-muted">Email không thể thay đổi</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarPlaceholder = document.getElementById('avatar-placeholder');
    
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (avatarPreview) {
                    avatarPreview.src = e.target.result;
                } else if (avatarPlaceholder) {
                    // Create new img element to replace placeholder
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Avatar';
                    img.id = 'avatar-preview';
                    img.className = 'rounded-circle mb-3';
                    img.style.cssText = 'width: 120px; height: 120px; object-fit: cover;';
                    
                    avatarPlaceholder.parentNode.replaceChild(img, avatarPlaceholder);
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
