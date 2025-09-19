@extends('layouts.app')

@section('title', 'Trego - Thương Mại Điện Tử')

@section('content')
<!-- Trego Homepage Layout - Modular Version -->
<div class="trego-homepage">
    <!-- Main Content Layout -->
    <div class="main-layout">
        <div class="container-fluid px-3">
            <div class="row g-3">
                <!-- Left Sidebar - Categories -->
                <div class="col-xl-2 col-lg-3 col-md-4 sidebar-column">
                    <div class="sticky-sidebar-wrapper">
                        @include('components.home.categories-sidebar')
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-xl-10 col-lg-9 col-md-8 main-content-column">
                    <!-- Banner Carousel -->
                    <div class="content-section">
                        @include('components.home.banner-carousel')
                    </div>
                    
                    <!-- Category Icons Section -->
                    <div class="content-section">
                        @include('components.home.category-icons')
                    </div>

                    <!-- TOP DEAL - SIÊU RẺ Section -->
                    <div class="content-section">
                    <div class="deals-section">
                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                            <h4 class="section-title mb-0">
                                <i class="fas fa-fire text-warning me-2"></i>
                                <span class="text-primary">TOP DEAL</span> - <span class="text-danger">SIÊU RẺ</span>
                            </h4>
                            <div class="d-flex align-items-center gap-2">
                                <button class="section-next-btn" id="top-deal-next">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Xem tất cả →</a>
                            </div>
                        </div>
                        
                        <div class="row g-2">
                            @forelse($featuredProducts as $product)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                    <div class="product-card-modern">
                                        <div class="product-image-wrapper">
                                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/200x200/f8f9fa/6c757d?text=Product' }}" 
                                                 alt="{{ $product->name }}" class="product-image">
                                            <div class="product-badges">
                                                <span class="badge bg-danger">-{{ rand(10, 50) }}%</span>
                                            </div>
                                            <div class="product-actions">
                                                <button class="btn btn-sm btn-outline-primary" onclick="addToCart({{ $product->id }})">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <h6 class="product-title">{{ Str::limit($product->name, 50) }}</h6>
                                            <div class="product-rating">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="product-price">
                                                <span class="current-price">{{ number_format($product->price) }}₫</span>
                                                <span class="original-price">{{ number_format($product->price * 1.3) }}₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @for($i = 1; $i <= 12; $i++)
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                        <div class="product-card-modern">
                                            <div class="product-image-wrapper">
                                                <img src="https://via.placeholder.com/200x200/f8f9fa/6c757d?text=Product+{{ $i }}" 
                                                     alt="Product {{ $i }}" class="product-image">
                                                <div class="product-badges">
                                                    <span class="badge bg-danger">-{{ rand(10, 50) }}%</span>
                                                </div>
                                                <div class="product-actions">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="addToCart({{ $i }})">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h6 class="product-title">Sản phẩm hot {{ $i }}</h6>
                                                <div class="product-rating">
                                                    <div class="stars">
                                                        @for($j = 1; $j <= 5; $j++)
                                                            <i class="fas fa-star {{ $j <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="product-price">
                                                    <span class="current-price">{{ number_format(rand(100000, 2000000)) }}₫</span>
                                                    <span class="original-price">{{ number_format(rand(2000000, 3000000)) }}₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                    </div>
                    </div>

                    <!-- Flash Sale Section -->
                    <div class="content-section">
                        @include('components.home.flash-sale')
                    </div>

                    <!-- Featured Brands Section -->
                    <div class="content-section">
                    <div class="featured-brands-section mb-4">
                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                            <h4 class="section-title mb-0">
                                <i class="fas fa-crown text-warning me-2"></i>
                                Thương hiệu nổi bật
                            </h4>
                            <div class="d-flex align-items-center gap-2">
                                <button class="section-next-btn" id="brands-next">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <a href="#" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                            </div>
                        </div>
                        
                        <div class="brands-carousel-container">
                            <div class="brands-carousel">
                                <!-- Brand Cards -->
                                @for($i = 1; $i <= 8; $i++)
                                    <div class="brand-card flex-shrink-0">
                                        <div class="brand-image-container">
                                            <div class="brand-placeholder-content bg-primary">
                                                <div class="brand-logo">
                                                    <i class="fas fa-star text-white"></i>
                                                    <span class="brand-name text-white">BRAND {{ $i }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="brand-details">
                                            <h6 class="brand-title">Brand {{ $i }}</h6>
                                            <p class="brand-subtitle">Giảm giá đến {{ rand(10, 50) }}%</p>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Hàng ngoại giá hot Section -->
                    <div class="content-section">
                    <div class="hang-ngoai-gia-hot-section mb-4">
                        <div class="section-header d-flex justify-content-between align-items-center mb-3">
                            <h4 class="section-title mb-0">Hàng ngoại giá hot</h4>
                            <a href="#" class="btn btn-link text-primary p-0">
                                Xem tất cả
                            </a>
                        </div>
                        
                        <div class="hang-ngoai-container position-relative">
                            <div class="hang-ngoai-grid" id="hang-ngoai-grid">
                                @for($i = 1; $i <= 6; $i++)
                                    <div class="hang-ngoai-product-card">
                                        <div class="product-image-container position-relative">
                                            <img src="https://via.placeholder.com/200x200/f8f9fa/6c757d?text=Product+{{ $i }}" alt="Product {{ $i }}" class="hang-ngoai-product-image">
                                            <div class="discount-badge-hang-ngoai">-{{ rand(10, 50) }}%</div>
                                            @if($i <= 3)
                                                <div class="now-badge">NOW</div>
                                            @endif
                                            <div class="origin-badge">Made in {{ ['Germany', 'Japan', 'France', 'USA', 'Korea'][$i % 5] }}</div>
                                        </div>
                                        <div class="hang-ngoai-product-details">
                                            <h6 class="hang-ngoai-product-title">Sản phẩm ngoại nhập {{ $i }} chất lượng cao...</h6>
                                            <div class="rating-stars mb-2">
                                                @for($j = 1; $j <= 5; $j++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                            <div class="price-container">
                                                <span class="current-price">{{ number_format(rand(200000, 3000000)) }}₫</span>
                                                <span class="original-price">{{ number_format(rand(3000000, 4000000)) }}₫</span>
                                            </div>
                                            <div class="delivery-info">
                                                <small class="text-muted">{{ $i <= 3 ? 'Giao siêu tốc 2h' : 'Giao thứ ' . rand(2, 7) . ', ' . rand(20, 30) . '/09' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            
                            <!-- Next Button -->
                            <button class="section-next-btn hang-ngoai-next-btn" id="hang-ngoai-next">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    </div>

                    <!-- Bạn có thể thích Section -->
                    <div class="content-section">
                        @include('components.home.ban-co-the-thich')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Home Page JavaScript -->
<script src="{{ asset('js/components/categories-scroll.js') }}"></script>
<script src="{{ asset('js/components/sticky-sidebar.js') }}"></script>
<script src="{{ asset('js/components/home-functions.js') }}"></script>
@endsection
