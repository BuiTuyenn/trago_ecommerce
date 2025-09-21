{{-- Product Filter Component --}}
@props([
    'action' => route('products.index'),
    'headerTitle' => 'Bộ lọc sản phẩm',
    'headerBg' => 'bg-primary',
    'resetRoute' => route('products.index'),
    'showQuickFilter' => true,
    'enableAutoSubmit' => true,
    'filterParams' => ['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'sort']
])

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm product-filter-card">
            <div class="card-header {{ $headerBg }} text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>{{ $headerTitle }}
                    </h5>
                    <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true">
                        <i class="fas fa-chevron-up" id="filterToggleIcon"></i>
                    </button>
                </div>
            </div>
            <div class="collapse show" id="filterCollapse">
                <div class="card-body">
                    <form method="GET" action="{{ $action }}" id="filterForm">
                        <!-- Row 1: Search and Basic Filters -->
                        <div class="row g-3 mb-3">
                            <!-- Search -->
                            <div class="col-lg-4 col-md-6">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search me-1"></i>Tìm kiếm sản phẩm
                                </label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Nhập tên sản phẩm, mô tả...">
                            </div>
                            
                            <!-- Price Range -->
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-dollar-sign me-1"></i>Khoảng giá
                                </label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="number" class="form-control" id="min_price" name="min_price" 
                                               value="{{ request('min_price') }}" placeholder="Từ" min="0">
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="text-muted">-</span>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" id="max_price" name="max_price" 
                                               value="{{ request('max_price') }}" placeholder="Đến" min="0">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="col-lg-2 col-md-6">
                                <label for="stock_status" class="form-label">
                                    <i class="fas fa-boxes me-1"></i>Tình trạng
                                </label>
                                <select class="form-select" id="stock_status" name="stock_status">
                                    <option value="">Tất cả</option>
                                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Sắp hết hàng</option>
                                </select>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i>Lọc
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Advanced Filters -->
                        <div class="row g-3">
                            <!-- Sort Options -->
                            <div class="col-lg-3 col-md-6">
                                <label for="sort" class="form-label">
                                    <i class="fas fa-sort me-1"></i>Sắp xếp theo
                                </label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá thấp → cao</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá cao → thấp</option>
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                                </select>
                            </div>

                            <!-- Product Type -->
                            <div class="col-lg-3 col-md-6">
                                <label for="product_type" class="form-label">
                                    <i class="fas fa-tags me-1"></i>Loại sản phẩm
                                </label>
                                <select class="form-select" id="product_type" name="product_type">
                                    <option value="">Tất cả loại</option>
                                    <option value="featured" {{ request('product_type') == 'featured' ? 'selected' : '' }}>Sản phẩm nổi bật</option>
                                    <option value="new" {{ request('product_type') == 'new' ? 'selected' : '' }}>Sản phẩm mới</option>
                                    <option value="sale" {{ request('product_type') == 'sale' ? 'selected' : '' }}>Đang giảm giá</option>
                                    <option value="bestseller" {{ request('product_type') == 'bestseller' ? 'selected' : '' }}>Bán chạy</option>
                                </select>
                            </div>

                            <!-- Price Range Presets -->
                            <div class="col-lg-3 col-md-6">
                                <label for="price_range" class="form-label">
                                    <i class="fas fa-money-bill me-1"></i>Mức giá
                                </label>
                                <select class="form-select" id="price_range" name="price_range">
                                    <option value="">Chọn mức giá</option>
                                    <option value="under_100k" {{ request('price_range') == 'under_100k' ? 'selected' : '' }}>Dưới 100.000₫</option>
                                    <option value="100k_500k" {{ request('price_range') == '100k_500k' ? 'selected' : '' }}>100.000₫ - 500.000₫</option>
                                    <option value="500k_1m" {{ request('price_range') == '500k_1m' ? 'selected' : '' }}>500.000₫ - 1.000.000₫</option>
                                    <option value="1m_5m" {{ request('price_range') == '1m_5m' ? 'selected' : '' }}>1.000.000₫ - 5.000.000₫</option>
                                    <option value="5m_10m" {{ request('price_range') == '5m_10m' ? 'selected' : '' }}>5.000.000₫ - 10.000.000₫</option>
                                    <option value="over_10m" {{ request('price_range') == 'over_10m' ? 'selected' : '' }}>Trên 10.000.000₫</option>
                                </select>
                            </div>

                            <!-- Rating Filter -->
                            <div class="col-lg-3 col-md-6">
                                <label for="rating" class="form-label">
                                    <i class="fas fa-star me-1"></i>Đánh giá
                                </label>
                                <select class="form-select" id="rating" name="rating">
                                    <option value="">Tất cả đánh giá</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 sao trở lên</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 sao trở lên</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 sao trở lên</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Reset Button Row -->
                        @if(request()->hasAny($filterParams))
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <a href="{{ $resetRoute }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Xóa tất cả bộ lọc
                                    </a>
                                    @if($showQuickFilter)
                                        <button type="button" class="btn btn-outline-info ms-2" id="quickFilterBtn">
                                            <i class="fas fa-magic me-1"></i>Bộ lọc nhanh
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/components/product-filter.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/components/product-filter.css') }}">
@endpush
