@extends('layouts.app')

@section('title', 'Viết đánh giá')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></li>
                    <li class="breadcrumb-item active">Viết đánh giá</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Đánh giá sản phẩm
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Product Info -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="me-3 rounded"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="me-3 bg-secondary rounded d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-image text-white"></i>
                            </div>
                        @endif
                        
                        <div>
                            <h5 class="mb-1">{{ $product->name }}</h5>
                            <p class="mb-1 text-danger fw-bold">{{ number_format($product->effective_price) }}₫</p>
                            @if($hasPurchased)
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Đã mua sản phẩm này
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Chưa mua sản phẩm này
                                </small>
                            @endif
                        </div>
                    </div>

                    @if(!$hasPurchased)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Lưu ý:</strong> Bạn chưa mua sản phẩm này. Đánh giá sẽ không được đánh dấu là "Đã mua hàng".
                        </div>
                    @endif

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @if($order)
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                        @endif

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label">
                                <strong>Đánh giá của bạn <span class="text-danger">*</span></strong>
                            </label>
                            <div class="rating-input">
                                <div class="stars-input mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star star-input" data-rating="{{ $i }}" style="font-size: 2rem; color: #ddd; cursor: pointer;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="{{ old('rating') }}">
                                <small class="text-muted">Nhấp vào sao để đánh giá</small>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <strong>Tiêu đề đánh giá</strong>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Tóm tắt đánh giá của bạn (tùy chọn)"
                                   maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="form-label">
                                <strong>Nội dung đánh giá <span class="text-danger">*</span></strong>
                            </label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="5" 
                                      placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."
                                      maxlength="1000">{{ old('comment') }}</textarea>
                            <small class="text-muted">Tối đa 1000 ký tự</small>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Gửi đánh giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.star-input:hover,
.star-input.active {
    color: #ffc107 !important;
}

.star-input.fas {
    color: #ffc107 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-input');
    const ratingValue = document.getElementById('rating-value');
    
    // Set initial rating if exists
    const initialRating = ratingValue.value;
    if (initialRating) {
        setRating(initialRating);
    }
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            setRating(rating);
            ratingValue.value = rating;
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            highlightStars(rating);
        });
    });
    
    document.querySelector('.stars-input').addEventListener('mouseleave', function() {
        const currentRating = ratingValue.value;
        if (currentRating) {
            setRating(currentRating);
        } else {
            clearStars();
        }
    });
    
    function setRating(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas');
                star.classList.add('active');
            } else {
                star.classList.remove('fas', 'active');
                star.classList.add('far');
            }
        });
    }
    
    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
    
    function clearStars() {
        stars.forEach(star => {
            star.style.color = '#ddd';
            star.classList.remove('fas', 'active');
            star.classList.add('far');
        });
    }
});
</script>
@endsection
