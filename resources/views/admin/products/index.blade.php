@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="mb-0">
            <i class="fas fa-cube me-2"></i>
            Danh sách sản phẩm
        </h4>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Thêm sản phẩm mới
        </a>
    </div>
</div>

<!-- Filter and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tìm kiếm</label>
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tên sản phẩm, SKU...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Danh mục</label>
                <select class="form-select" name="category_id">
                    <option value="">Tất cả danh mục</option>
                    @php
                        $categories = \App\Models\Category::active()->parent()->with('children')->get();
                    @endphp
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
            <div class="col-md-2">
                <label class="form-label">Trạng thái</label>
                <select class="form-select" name="status">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-search me-1"></i>
                        Lọc
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body">
        @php
            $products = \App\Models\Product::with('category')
                ->when(request('search'), function($query) {
                    $query->where('name', 'like', '%' . request('search') . '%')
                          ->orWhere('sku', 'like', '%' . request('search') . '%');
                })
                ->when(request('category_id'), function($query) {
                    $query->where('category_id', request('category_id'));
                })
                ->when(request('status'), function($query) {
                    $query->where('status', request('status'));
                })
                ->latest()
                ->paginate(15);
        @endphp

        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="80">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>SKU</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th width="120">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->hasImages())
                                        <img src="{{ $product->first_image }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->name }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($product->name, 40) }}</h6>
                                        @if($product->featured)
                                            <span class="badge bg-warning">Nổi bật</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <code>{{ $product->sku }}</code>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    @if($product->sale_price)
                                        <div>
                                            <strong class="text-danger">{{ number_format($product->sale_price, 0, ',', '.') }}₫</strong>
                                        </div>
                                        <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}₫</small>
                                    @else
                                        <strong>{{ number_format($product->price, 0, ',', '.') }}₫</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($product->stock_quantity <= 10 && $product->stock_quantity > 0)
                                        <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                        <small class="text-muted d-block">Sắp hết</small>
                                    @elseif($product->stock_quantity == 0)
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($product->status)
                                        @case('active')
                                            <span class="badge bg-success">Hoạt động</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge bg-secondary">Tạm dừng</span>
                                            @break
                                        @case('draft')
                                            <span class="badge bg-warning">Bản nháp</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-info" target="_blank" title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="d-inline" onsubmit="return confirmDelete('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Hiển thị {{ $products->firstItem() }}-{{ $products->lastItem() }} trong tổng số {{ $products->total() }} sản phẩm
                    </small>
                </div>
                <div>
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không tìm thấy sản phẩm nào</h5>
                <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc thêm sản phẩm mới</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Thêm sản phẩm đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    
    .btn-group-sm > .btn, .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .img-thumbnail {
        border-radius: 0.375rem;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    code {
        color: #6f42c1;
        background-color: #f8f9fa;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
    }
</style>
@endpush
