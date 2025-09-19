@extends('layouts.app')

@section('title', 'Nhà Cửa & Đời Sống - Trego')

@push('styles')
    @vite('resources/css/pages/categories/home-living.css')
    @vite('resources/css/components/pagination/pagination.css')
    @vite('resources/css/components/sidebar/sidebar.css')
@endpush

@section('content')
<div class="bookstore-page">
    <!-- Breadcrumb -->
    <div class="container-fluid px-3">
        <nav aria-label="breadcrumb" class="py-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container-fluid px-3 py-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="bookstore-sidebar">
                    <h5 class="sidebar-title">Khám phá theo danh mục</h5>
                    
                    <ul class="category-list">
                        <!-- Nội thất - Expanded by default -->
                        <li class="category-item expandable expanded">
                            <a href="#" class="category-link" onclick="return toggleCategory(this, event);">
                                <span>Nội thất</span>
                                <i class="fas fa-chevron-up"></i>
                            </a>
                            <ul class="subcategory-list">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Bàn ghế</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Tủ kệ</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Giường ngủ</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Sofa</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Nệm</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Tủ quần áo</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Bàn trang điểm</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Kệ sách</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Đồ gia dụng - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="return toggleCategory(this, event);">
                                <span>Đồ gia dụng</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="subcategory-list" style="display: none;">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Dụng cụ nhà bếp</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Đồ lưu trữ</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Đồ dùng phòng tắm</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Đồ trang trí</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Thiết bị gia đình - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="return toggleCategory(this, event);">
                                <span>Thiết bị gia đình</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="subcategory-list" style="display: none;">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Máy lạnh</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Tủ lạnh</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Máy giặt</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Lò vi sóng</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Văn phòng phẩm - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="return toggleCategory(this, event);">
                                <span>Văn phòng phẩm</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="subcategory-list" style="display: none;">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Bút viết</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Sổ tay</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Dụng cụ văn phòng</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Quà lưu niệm - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="return toggleCategory(this, event);">
                                <span>Quà lưu niệm</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="subcategory-list" style="display: none;">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Đồ chơi</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Trang sức</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Đồ trang trí</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Main Content -->
            <div class="col-lg-9 col-md-8">
                <div class="bookstore-main">
                    <h1 class="bookstore-title">{{ $category->name }}</h1>
                    
                    <!-- Advanced Filter Bar -->
                    <div class="advanced-filter-bar mb-4">
                        <!-- Filter Tags Row -->
                        <div class="filter-row">
                            <div class="filter-section">
                                <label class="filter-label">Bộ lọc:</label>
                                <div class="filter-tags">
                                    <button class="filter-btn active" data-filter="all">
                                        <i class="fas fa-home"></i>
                                        Tất cả sản phẩm
                                    </button>
                                    <button class="filter-btn" data-filter="bestseller">
                                        <i class="fas fa-fire"></i>
                                        Bán chạy
                                    </button>
                                    <button class="filter-btn" data-filter="featured">
                                        <i class="fas fa-star"></i>
                                        Nổi bật
                                    </button>
                                    <button class="filter-btn freeship-badge" data-filter="freeship">
                                        <i class="fas fa-shipping-fast"></i>
                                        FREESHIP
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Filters Row -->
                        <div class="advanced-filters-row">
                            <!-- Price Range Filter -->
                            <div class="filter-group">
                                <label class="filter-label">Khoảng giá:</label>
                                <div class="price-filter">
                                    <select class="price-select">
                                        <option value="">Chọn mức giá</option>
                                        <option value="0-500000">Dưới 500.000đ</option>
                                        <option value="500000-1000000">500.000đ - 1.000.000đ</option>
                                        <option value="1000000-2000000">1.000.000đ - 2.000.000đ</option>
                                        <option value="2000000-5000000">2.000.000đ - 5.000.000đ</option>
                                        <option value="5000000-999999999">Trên 5.000.000đ</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            <div class="filter-group">
                                <label class="filter-label">Thương hiệu:</label>
                                <select class="brand-select">
                                    <option value="">Tất cả thương hiệu</option>
                                    <option value="IKEA">IKEA</option>
                                    <option value="Hòa Phát">Hòa Phát</option>
                                    <option value="Điện Máy Xanh">Điện Máy Xanh</option>
                                    <option value="Sunhouse">Sunhouse</option>
                                    <option value="Panasonic">Panasonic</option>
                                    <option value="Samsung">Samsung</option>
                                </select>
                            </div>

                            <!-- Material Filter -->
                            <div class="filter-group">
                                <label class="filter-label">Chất liệu:</label>
                                <div class="material-filter">
                                    <button class="mat-btn active" data-material="all">Tất cả</button>
                                    <button class="mat-btn" data-material="wood">Gỗ</button>
                                    <button class="mat-btn" data-material="metal">Kim loại</button>
                                    <button class="mat-btn" data-material="plastic">Nhựa</button>
                                </div>
                            </div>
                            
                            <!-- Sort Options -->
                            <div class="filter-group">
                                <label class="filter-label">Sắp xếp:</label>
                                <select class="sort-select">
                                    <option value="popular">Phổ biến nhất</option>
                                    <option value="newest">Mới nhất</option>
                                    <option value="bestseller">Bán chạy nhất</option>
                                    <option value="price_asc">Giá thấp → cao</option>
                                    <option value="price_desc">Giá cao → thấp</option>
                                    <option value="rating">Đánh giá cao</option>
                                    <option value="discount">Giảm giá nhiều</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filter Actions -->
                        <div class="filter-actions">
                            <button class="btn-reset-filter">
                                <i class="fas fa-undo"></i>
                                Xóa bộ lọc
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        @forelse($products as $product)
                            <div class="product-card" data-featured="{{ $product->featured ? 'true' : 'false' }}" data-bestseller="{{ $product->bestseller ? 'true' : 'false' }}">
                                <!-- Product Image -->
                                <div class="product-image">
                                    @if($product->images && is_array($product->images) && count($product->images) > 0)
                                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="product-placeholder">
                                            <i class="fas fa-home"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    <div class="product-badges">
                                        @if($product->price && $product->sale_price && floatval($product->price) > floatval($product->sale_price))
                                            <span class="discount-badge">-{{ round(((floatval($product->price) - floatval($product->sale_price)) / floatval($product->price)) * 100) }}%</span>
                                        @endif
                                        @if($product->featured)
                                            <span class="freeship-badge">FREESHIP XTRA</span>
                                        @endif
                                        @if($product->bestseller)
                                            <span class="authentic-badge">CHÍNH HÃNG</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="product-info">
                                    <!-- Price -->
                                    <div class="product-price">
                                        @if($product->sale_price)
                                            <span class="current-price">{{ number_format(floatval($product->sale_price), 0, ',', '.') }}<sup>đ</sup></span>
                                            @if(floatval($product->price) > floatval($product->sale_price))
                                                <span class="original-price">{{ number_format(floatval($product->price), 0, ',', '.') }}<sup>đ</sup></span>
                                            @endif
                                        @else
                                            <span class="current-price">{{ number_format(floatval($product->price), 0, ',', '.') }}<sup>đ</sup></span>
                                        @endif
                                    </div>

                                    <!-- Brand -->
                                    <div class="product-brand">{{ $product->brand ?? 'TREGO' }}</div>

                                    <!-- Title -->
                                    <div class="product-title">{{ $product->name }}</div>

                                    <!-- Rating -->
                                    <div class="product-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="sold-count">Đã bán {{ rand(50, 300) }}</span>
                                    </div>

                                    <!-- Special Offers -->
                                    @if($product->featured)
                                        <div class="special-offers">
                                            <span class="offer-badge">Mua 3 giảm 5%</span>
                                        </div>
                                    @endif

                                    <!-- Delivery Info -->
                                    <div class="delivery-info">
                                        Giao {{ ['chủ nhật', 'thứ 2', 'thứ 3', 'thứ 4', 'thứ 5'][rand(0, 4)] }}, {{ date('d/m', strtotime('+' . rand(1, 5) . ' days')) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="no-products">
                                    <i class="fas fa-box-open"></i>
                                    <h3>Không có sản phẩm nào</h3>
                                    <p>Vui lòng thử lại sau hoặc liên hệ với chúng tôi.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Component -->
                    @include('components.pagination.custom-pagination', ['paginator' => $products])
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @vite('resources/js/pages/categories/home-living.js')
    @vite('resources/js/components/sidebar/sidebar.js')
    <script>
    function toggleCategory(element, event) {
        // Prevent default link behavior and focus issues
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        const categoryItem = element.closest('.category-item');
        const subcategoryList = categoryItem.querySelector('.subcategory-list');
        const icon = element.querySelector('i');
        
        if (categoryItem.classList.contains('expanded')) {
            // Collapse
            categoryItem.classList.remove('expanded');
            subcategoryList.style.display = 'none';
            icon.className = 'fas fa-chevron-down';
        } else {
            // Expand
            categoryItem.classList.add('expanded');
            subcategoryList.style.display = 'block';
            icon.className = 'fas fa-chevron-up';
        }
        
        // Remove focus from the clicked element
        element.blur();
        
        return false;
    }
    </script>
@endpush
