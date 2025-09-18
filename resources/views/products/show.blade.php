@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                @if($product->hasImages())
                    <!-- Main Image -->
                    <div class="main-image mb-3">
                        <img id="mainImage" src="{{ $product->first_image }}" class="img-fluid rounded shadow" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover;">
                    </div>
                    
                    <!-- Thumbnail Images -->
                    @if(count($product->images_array) > 1)
                        <div class="thumbnail-images">
                            <div class="row g-2">
                                @foreach($product->images_array as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ $image }}" 
                                             class="img-fluid rounded thumbnail-img {{ $index == 0 ? 'active' : '' }}" 
                                             alt="{{ $product->name }}"
                                             onclick="changeMainImage('{{ $image }}', this)"
                                             style="height: 80px; object-fit: cover; cursor: pointer; border: 2px solid {{ $index == 0 ? '#007bff' : 'transparent' }};">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <img src="https://via.placeholder.com/500x400/f8f9fa/6c757d?text=No+Image" class="img-fluid rounded" alt="{{ $product->name }}">
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Product Name -->
                <h1 class="h3 mb-3">{{ $product->name }}</h1>
                
                <!-- Category -->
                <p class="text-muted mb-2">
                    <i class="fas fa-tag me-1"></i>
                    Danh mục: <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none">{{ $product->category->name }}</a>
                </p>
                
                <!-- SKU -->
                <p class="text-muted mb-3">
                    <i class="fas fa-barcode me-1"></i>
                    Mã sản phẩm: <strong>{{ $product->sku }}</strong>
                </p>
                
                <!-- Reviews -->
                @if($product->reviews_count > 0)
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $product->average_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted">
                                {{ number_format($product->average_rating, 1) }}/5 
                                ({{ $product->reviews_count }} đánh giá)
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Price -->
                <div class="price-section mb-4">
                    @if($product->sale_price)
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-danger fw-bold fs-2 me-3">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                            <span class="badge bg-danger">
                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </span>
                        </div>
                        <p class="text-muted text-decoration-line-through mb-0">
                            Giá gốc: {{ number_format($product->price, 0, ',', '.') }}₫
                        </p>
                    @else
                        <span class="text-primary fw-bold fs-2">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="stock-status mb-4">
                    @if($product->in_stock && $product->stock_quantity > 0)
                        <div class="alert alert-success py-2">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Còn hàng</strong> - {{ $product->stock_quantity }} sản phẩm có sẵn
                        </div>
                    @else
                        <div class="alert alert-danger py-2">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Hết hàng</strong>
                        </div>
                    @endif
                </div>

                <!-- Product Specifications -->
                @if($product->weight || $product->dimensions)
                    <div class="specifications mb-4">
                        <h6 class="fw-bold mb-3">Thông số kỹ thuật:</h6>
                        <div class="row">
                            @if($product->weight)
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Trọng lượng:</small><br>
                                    <strong>{{ $product->weight }}{{ is_numeric($product->weight) ? 'g' : '' }}</strong>
                                </div>
                            @endif
                            @if($product->dimensions)
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Kích thước:</small><br>
                                    <strong>{{ $product->dimensions }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->in_stock && $product->stock_quantity > 0)
                    <div class="add-to-cart-section mb-4">
                        <form id="addToCartForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="row align-items-end">
                                <div class="col-4">
                                    <label class="form-label">Số lượng:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                        <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-cart-plus me-2"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-danger w-100" onclick="addToWishlist({{ $product->id }})">
                                <i class="far fa-heart me-1"></i>
                                Yêu thích
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-info w-100" onclick="shareProduct()">
                                <i class="fas fa-share-alt me-1"></i>
                                Chia sẻ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                <i class="fas fa-info-circle me-1"></i>
                                Mô tả sản phẩm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                                <i class="fas fa-star me-1"></i>
                                Đánh giá ({{ $product->reviews_count }})
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="productTabContent">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product-description">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                        
                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            @if($product->reviews->count() > 0)
                                @foreach($product->reviews as $review)
                                    <div class="review-item border-bottom py-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong>{{ $review->user->full_name ?? $review->user->name }}</strong>
                                                @if($review->verified_purchase)
                                                    <span class="badge bg-success ms-2">Đã mua hàng</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        
                                        <div class="text-warning mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        
                                        @if($review->title)
                                            <h6>{{ $review->title }}</h6>
                                        @endif
                                        
                                        @if($review->comment)
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Chưa có đánh giá nào</h5>
                                    <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-4">
                    <i class="fas fa-cube me-2"></i>
                    Sản phẩm liên quan
                </h4>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card product-card h-100">
                                @if($relatedProduct->hasImages())
                                    <img src="{{ $relatedProduct->first_image }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $relatedProduct->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $relatedProduct->name }}">
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($relatedProduct->name, 50) }}
                                        </a>
                                    </h6>
                                    
                                    <div class="mt-auto">
                                        <div class="mb-2">
                                            @if($relatedProduct->sale_price)
                                                <span class="text-danger fw-bold">{{ number_format($relatedProduct->sale_price, 0, ',', '.') }}₫</span>
                                                <small class="text-muted text-decoration-line-through ms-1">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</small>
                                            @else
                                                <span class="text-primary fw-bold">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</span>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                            @if($relatedProduct->in_stock && $relatedProduct->stock_quantity > 0)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addToCart({{ $relatedProduct->id }})">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Change main image when thumbnail is clicked
    function changeMainImage(imageSrc, element) {
        document.getElementById('mainImage').src = imageSrc;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.style.border = '2px solid transparent';
            img.classList.remove('active');
        });
        
        element.style.border = '2px solid #007bff';
        element.classList.add('active');
    }

    // Quantity controls
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max);
        
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }

    // Add to cart form submission
    document.getElementById('addToCartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const productId = formData.get('product_id');
        const quantity = formData.get('quantity');
        
        addToCart(productId, quantity);
    });

    // Add to wishlist (placeholder)
    function addToWishlist(productId) {
        showAlert('info', 'Tính năng yêu thích sẽ được phát triển trong tương lai!');
    }

    // Share product (placeholder)
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: '{{ $product->short_description }}',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                showAlert('success', 'Đã sao chép link sản phẩm vào clipboard!');
            });
        }
    }
</script>
@endpush

@push('styles')
<style>
    .product-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .thumbnail-img {
        transition: all 0.3s ease;
    }
    
    .thumbnail-img:hover {
        transform: scale(1.1);
    }
    
    .price-section {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        padding: 1rem;
        border-radius: 0.5rem;
        border-left: 4px solid #007bff;
    }
    
    .specifications {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
    }
    
    .review-item:last-child {
        border-bottom: none !important;
    }
    
    .main-image img {
        transition: transform 0.3s ease;
    }
    
    .main-image:hover img {
        transform: scale(1.05);
    }
</style>
@endpush
