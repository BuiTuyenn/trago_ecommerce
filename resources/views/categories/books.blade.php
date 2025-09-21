@extends('layouts.app')

@section('title', 'Nhà Sách Trego - Sách các thể loại')

@push('styles')
    @vite('resources/css/pages/categories/books.css')
    @vite('resources/css/components/pagination/pagination.css')
    @vite('resources/css/components/sidebar/sidebar.css')
    <style>
        /* Force remove all bullet points - INLINE OVERRIDE */
        .bookstore-sidebar ul,
        .bookstore-sidebar li,
        .category-list,
        .category-item,
        .subcategory-list,
        .subcategory-item {
            list-style: none !important;
            list-style-type: none !important;
            list-style-image: none !important;
            list-style-position: outside !important;
            margin-left: 0 !important;
            padding-left: 0 !important;
        }
        
        .bookstore-sidebar ul::before,
        .bookstore-sidebar li::before,
        .category-list::before,
        .category-item::before,
        .subcategory-list::before,
        .subcategory-item::before {
            content: none !important;
            display: none !important;
        }
        
        .bookstore-sidebar *::marker {
            content: none !important;
            display: none !important;
        }
        
        /* Reset any inherited list styles */
        .bookstore-sidebar * {
            list-style: none !important;
        }
        
        .bookstore-sidebar ul,
        .bookstore-sidebar ol {
            list-style: none !important;
        }
        
        /* Target specific subcategory items with dots */
        .subcategory-item::before,
        .subcategory-link::before {
            content: "" !important;
            display: none !important;
        }
        
        /* Remove any text-indent that might show bullets */
        .subcategory-item,
        .subcategory-link {
            text-indent: 0 !important;
            padding-left: 1rem !important;
        }
        
        /* Force override all list-related properties */
        .bookstore-sidebar .subcategory-list .subcategory-item {
            list-style: none !important;
            list-style-type: none !important;
            list-style-image: none !important;
            position: relative !important;
        }
        
        /* Remove any bullets from browser defaults */
        .bookstore-sidebar li {
            background: none !important;
        }
        
        /* Nuclear option - remove all possible bullet sources */
        .bookstore-sidebar *::before,
        .bookstore-sidebar *::after {
            content: none !important;
            display: none !important;
        }
        
        /* Restore only the chevron icons we want */
        .category-link i::before {
            content: "\f078" !important; /* fa-chevron-down */
            display: inline-block !important;
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }
        
        .category-item.expanded .category-link i::before {
            content: "\f077" !important; /* fa-chevron-up */
        }
        
        /* Make sure subcategory links have no decorations */
        .subcategory-link {
            position: relative !important;
            display: block !important;
            text-decoration: none !important;
        }
        /* Fix text-transform for category links */
        .category-link,
        .category-link span,
        .subcategory-link {
            text-transform: none !important;
        }
    </style>
@endpush

@section('content')
<div class="bookstore-page">
    <!-- Breadcrumb -->
    <div class="container-fluid px-3">
        <nav aria-label="breadcrumb" class="py-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nhà Sách Trego</li>
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
                        <!-- English Books - Expanded -->
                        <li class="category-item expandable expanded">
                            <a href="#" class="category-link" onclick="toggleCategory(this)">
                                <span>English Books</span>
                                <i class="fas fa-chevron-up"></i>
                            </a>
                            <ul class="subcategory-list">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Art & Photography</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Biographies & Memoirs</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Business & Economics</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">How-to - Self Help</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Children's Books</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Dictionary</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Education - Teaching</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Fiction - Literature</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Magazines</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Medical Books</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Parenting & Relationships</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Reference</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Science - Technology</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">History, Politics & Social Sciences</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Travel & Holiday</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Cookbooks, Food & Wine</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Sách tiếng Việt - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="toggleCategory(this)">
                                <span>Sách tiếng Việt</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="subcategory-list" style="display: none;">
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Văn học Việt Nam</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Kinh tế - Kinh doanh</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Kỹ năng sống</a>
                                </li>
                                <li class="subcategory-item">
                                    <a href="#" class="subcategory-link">Lịch sử - Địa lý</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Văn phòng phẩm - Collapsed -->
                        <li class="category-item expandable">
                            <a href="#" class="category-link" onclick="toggleCategory(this)">
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
                            <a href="#" class="category-link" onclick="toggleCategory(this)">
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

            <!-- Main Content Area -->
            <div class="col-lg-9 col-md-8">
                <div class="bookstore-main">
                    <h1 class="bookstore-title">Nhà Sách Trego</h1>
                    
                    <!-- Product Filter Component -->
                    <x-product-filter 
                        :action="route('categories.books')"
                        headerTitle="Bộ lọc sách"
                        headerBg="bg-info"
                        :resetRoute="route('categories.books')"
                        :showQuickFilter="true"
                        :enableAutoSubmit="true"
                        :filterParams="['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'brand', 'sort']"
                    />

                    <!-- Products Grid -->
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <!-- Product Image -->
                                <div class="product-image">
                                    @if($product->images_array && count($product->images_array) > 0)
                                        <img src="{{ asset('images/' . $product->images_array[0]) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="product-placeholder">
                                            <i class="fas fa-book"></i>
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

                                    <!-- Publisher/Brand -->
                                    <div class="product-brand">{{ $product->publisher ?? 'PHẠM HẰNG NGUYÊN' }}</div>

                                    <!-- Title -->
                                    <div class="product-title">{{ $product->title }}</div>

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
                        @endforeach
                    </div>

                    <!-- Pagination Component -->
                    @include('components.pagination.custom-pagination', ['paginator' => $products])
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Assistant Button -->
<div class="floating-assistant">
</div>

@push('scripts')
    @vite('resources/js/pages/categories/books.js')
    @vite('resources/js/components/sidebar/sidebar.js')
    <script>
        function toggleCategory(element) {
            event.preventDefault();
            
            const categoryItem = element.closest('.category-item');
            const subcategoryList = categoryItem.querySelector('.subcategory-list');
            const icon = element.querySelector('i');
            
            // Kiểm tra trạng thái hiện tại dựa trên display của subcategory
            const isCurrentlyOpen = subcategoryList.style.display === 'block';
            
            if (isCurrentlyOpen) {
                // Đang mở -> Đóng (mũi tên xuống)
                subcategoryList.style.display = 'none';
                categoryItem.classList.remove('expanded');
                icon.className = 'fas fa-chevron-down';
            } else {
                // Đang đóng -> Mở (mũi tên lên)
                subcategoryList.style.display = 'block';
                categoryItem.classList.add('expanded');
                icon.className = 'fas fa-chevron-up';
            }
        }
        
        // Đảm bảo trạng thái ban đầu đúng khi load trang
        document.addEventListener('DOMContentLoaded', function() {
            // Tất cả danh mục ban đầu đều đóng với mũi tên xuống
            const allCategoryItems = document.querySelectorAll('.category-item.expandable');
            allCategoryItems.forEach(item => {
                const subcategoryList = item.querySelector('.subcategory-list');
                const icon = item.querySelector('.category-link i');
                
                if (item.classList.contains('expanded')) {
                    // Nếu có class expanded, mở và đặt mũi tên lên
                    if (subcategoryList) {
                        subcategoryList.style.display = 'block';
                    }
                    if (icon) {
                        icon.className = 'fas fa-chevron-up';
                    }
                } else {
                    // Nếu không có class expanded, đóng và đặt mũi tên xuống
                    if (subcategoryList) {
                        subcategoryList.style.display = 'none';
                    }
                    if (icon) {
                        icon.className = 'fas fa-chevron-down';
                    }
                }
            });
        });
    </script>
@endpush
@endsection
