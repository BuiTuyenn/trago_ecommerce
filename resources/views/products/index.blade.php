@extends('layouts.app')

@section('title', 'Sản phẩm')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Sản phẩm</li>
                </ol>
            </nav>
            <h1 class="h2 mb-3">
                <i class="fas fa-cube me-2"></i>
                Tất cả sản phẩm
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Bộ lọc
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nhập tên sản phẩm...">
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục</label>
                            <select class="form-select" name="category_id">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;└ {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}" placeholder="Từ">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}" placeholder="Đến">
                                </div>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Lọc sản phẩm
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-1"></i>
                                Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Content -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        Hiển thị {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} 
                        trong tổng số {{ $products->total() }} sản phẩm
                    </p>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="{{ route('products.index') }}" class="d-flex justify-content-end">
                        @foreach(request()->except(['sort', 'order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select class="form-select" name="sort" onchange="this.form.submit()" style="width: auto;">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Giá thấp đến cao</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Mới nhất</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card product-card h-100">
                                <!-- Product Image -->
                                <div class="position-relative">
                                    @if($product->hasImages())
                                        <img src="{{ $product->first_image }}" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x250/f8f9fa/6c757d?text=No+Image" class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $product->name }}">
                                    @endif
                                    
                                    @if($product->featured)
                                        <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                            <i class="fas fa-star"></i> Nổi bật
                                        </span>
                                    @endif
                                    
                                    @if($product->sale_price)
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                            -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <!-- Category -->
                                    <small class="text-muted mb-1">{{ $product->category->name }}</small>
                                    
                                    <!-- Product Name -->
                                    <h6 class="card-title">
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    
                                    <!-- Short Description -->
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($product->short_description, 80) }}
                                    </p>
                                    
                                    <!-- Price -->
                                    <div class="mb-2">
                                        @if($product->sale_price)
                                            <span class="text-danger fw-bold fs-5">{{ number_format($product->sale_price, 0, ',', '.') }}₫</span>
                                            <small class="text-muted text-decoration-line-through ms-1">{{ number_format($product->price, 0, ',', '.') }}₫</small>
                                        @else
                                            <span class="text-primary fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Stock Status -->
                                    <div class="mb-2">
                                        @if($product->in_stock && $product->stock_quantity > 0)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i>
                                                Còn {{ $product->stock_quantity }} sản phẩm
                                            </small>
                                        @else
                                            <small class="text-danger">
                                                <i class="fas fa-times-circle"></i>
                                                Hết hàng
                                            </small>
                                        @endif
                                    </div>
                                    
                                    <!-- Reviews -->
                                    @if($product->reviews_count > 0)
                                        <div class="mb-2">
                                            <small class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($product->average_rating))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $product->average_rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="text-muted ms-1">({{ $product->reviews_count }})</span>
                                            </small>
                                        </div>
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    <div class="mt-auto">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                                <i class="fas fa-eye"></i> Xem chi tiết
                                            </a>
                                            @if($product->in_stock && $product->stock_quantity > 0)
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addToCart({{ $product->id }})">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                    <p class="text-muted">Vui lòng thử lại với từ khóa khác hoặc xóa bộ lọc</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-2"></i>
                        Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

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
    
    .card-img-top {
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .form-select {
        border-radius: 0.375rem;
    }
    
    .btn-outline-primary:hover {
        transform: none;
    }
</style>
@endpush
