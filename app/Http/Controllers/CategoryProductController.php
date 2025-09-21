<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    // Danh sách mapping category với thông tin
    private $categoryConfig = [
        'sach' => [
            'category_id' => 1,
            'title' => 'Sách Trego',
            'icon' => 'fas fa-book',
            'description' => 'Khám phá thế giới tri thức với bộ sưu tập sách phong phú',
            'keywords' => ['sách', 'giáo trình', 'tiểu thuyết', 'truyện', 'học tập']
        ],
        'nha-cua' => [
            'category_id' => 2,
            'title' => 'Nhà Cửa - Đời Sống',
            'icon' => 'fas fa-home',
            'description' => 'Trang trí và cải thiện không gian sống của bạn',
            'keywords' => ['nội thất', 'trang trí', 'đồ gia dụng', 'nhà cửa']
        ],
        'dien-thoai' => [
            'category_id' => 3,
            'title' => 'Điện Thoại - Máy Tính Bảng',
            'icon' => 'fas fa-mobile-alt',
            'description' => 'Công nghệ di động hàng đầu với giá tốt nhất',
            'keywords' => ['điện thoại', 'smartphone', 'máy tính bảng', 'tablet']
        ],
        'me-be' => [
            'category_id' => 4,
            'title' => 'Đồ Chơi - Mẹ và Bé',
            'icon' => 'fas fa-baby',
            'description' => 'Sản phẩm chăm sóc mẹ và bé an toàn, chất lượng',
            'keywords' => ['đồ chơi', 'mẹ và bé', 'sữa bột', 'ta giấy']
        ],
        'thiet-bi-so' => [
            'category_id' => 5,
            'title' => 'Thiết Bị Số - Phụ Kiện Số',
            'icon' => 'fas fa-headphones',
            'description' => 'Phụ kiện công nghệ thông minh và tiện dụng',
            'keywords' => ['tai nghe', 'sạc dự phòng', 'cáp sạc', 'phụ kiện']
        ],
        'dien-gia-dung' => [
            'category_id' => 6,
            'title' => 'Điện Gia Dụng',
            'icon' => 'fas fa-blender',
            'description' => 'Thiết bị điện gia dụng hiện đại, tiết kiệm điện',
            'keywords' => ['máy giặt', 'tủ lạnh', 'máy lọc nước', 'điện gia dụng']
        ],
        'lam-dep' => [
            'category_id' => 7,
            'title' => 'Làm Đẹp - Sức Khỏe',
            'icon' => 'fas fa-heart',
            'description' => 'Chăm sóc sức khỏe và làm đẹp toàn diện',
            'keywords' => ['mỹ phẩm', 'chăm sóc da', 'thực phẩm chức năng']
        ],
        'xe-co' => [
            'category_id' => 8,
            'title' => 'Ô Tô - Xe Máy - Xe Đạp',
            'icon' => 'fas fa-car',
            'description' => 'Phụ tung và phụ kiện xe cộ chính hãng',
            'keywords' => ['ô tô', 'xe máy', 'xe đạp', 'phụ tùng']
        ],
        'thoi-trang-nu' => [
            'category_id' => 9,
            'title' => 'Thời Trang Nữ',
            'icon' => 'fas fa-female',
            'description' => 'Thời trang nữ trendy, phong cách và chất lượng',
            'keywords' => ['váy', 'áo', 'quần', 'thời trang nữ']
        ],
        'bach-hoa' => [
            'category_id' => 10,
            'title' => 'Bách Hóa Online',
            'icon' => 'fas fa-shopping-basket',
            'description' => 'Mua sắm hàng hóa thiết yếu tiện lợi tại nhà',
            'keywords' => ['thực phẩm', 'đồ dùng', 'sinh hoạt', 'bách hóa']
        ],
        'the-thao' => [
            'category_id' => 11,
            'title' => 'Thể Thao - Dã Ngoại',
            'icon' => 'fas fa-running',
            'description' => 'Dụng cụ thể thao và hoạt động ngoài trời',
            'keywords' => ['thể thao', 'dã ngoại', 'gym', 'outdoor']
        ],
        'thoi-trang-nam' => [
            'category_id' => 12,
            'title' => 'Thời Trang Nam',
            'icon' => 'fas fa-male',
            'description' => 'Thời trang nam lịch lãm, phong cách hiện đại',
            'keywords' => ['áo nam', 'quần nam', 'suit', 'thời trang nam']
        ],
        'cross-border' => [
            'category_id' => 13,
            'title' => 'Cross Border - Hàng Quốc Tế',
            'icon' => 'fas fa-globe',
            'description' => 'Sản phẩm quốc tế chính hãng, chất lượng cao',
            'keywords' => ['hàng quốc tế', 'nhập khẩu', 'chính hãng']
        ],
        'laptop' => [
            'category_id' => 14,
            'title' => 'Laptop - Máy Vi Tính',
            'icon' => 'fas fa-laptop',
            'description' => 'Laptop và máy tính hiệu suất cao cho mọi nhu cầu',
            'keywords' => ['laptop', 'máy tính', 'gaming', 'văn phòng']
        ],
        'giay-dep-nam' => [
            'category_id' => 15,
            'title' => 'Giày - Dép Nam',
            'icon' => 'fas fa-shoe-prints',
            'description' => 'Giày dép nam phong cách, thoải mái và bền đẹp',
            'keywords' => ['giày nam', 'dép nam', 'sneaker', 'sandal']
        ],
        'dien-tu-dien-lanh' => [
            'category_id' => 16,
            'title' => 'Điện Tử - Điện Lạnh',
            'icon' => 'fas fa-tv',
            'description' => 'Thiết bị điện tử và điện lạnh cao cấp',
            'keywords' => ['tivi', 'máy lạnh', 'tủ lạnh', 'điện lạnh']
        ],
        'giay-dep-nu' => [
            'category_id' => 17,
            'title' => 'Giày - Dép Nữ',
            'icon' => 'fas fa-shoe-prints',
            'description' => 'Giày dép nữ thời trang, đa dạng mẫu mã',
            'keywords' => ['giày nữ', 'dép nữ', 'cao gót', 'bệt']
        ],
        'may-anh' => [
            'category_id' => 18,
            'title' => 'Máy Ảnh - Máy Quay Phim',
            'icon' => 'fas fa-camera',
            'description' => 'Thiết bị chụp ảnh, quay phim chuyên nghiệp',
            'keywords' => ['máy ảnh', 'camera', 'quay phim', 'lens']
        ],
        'phu-kien-thoi-trang' => [
            'category_id' => 19,
            'title' => 'Phụ Kiện Thời Trang',
            'icon' => 'fas fa-ring',
            'description' => 'Phụ kiện thời trang làm nổi bật phong cách',
            'keywords' => ['túi xách', 'đồng hồ', 'trang sức', 'phụ kiện']
        ],
        'voucher-dich-vu' => [
            'category_id' => 20,
            'title' => 'Voucher - Dịch Vụ',
            'icon' => 'fas fa-gamepad',
            'description' => 'Voucher và dịch vụ giải trí, tiện ích',
            'keywords' => ['voucher', 'dịch vụ', 'giải trí', 'thẻ cào']
        ],
        'thuc-pham' => [
            'category_id' => 21,
            'title' => 'Thực Phẩm - Đồ Uống',
            'icon' => 'fas fa-utensils',
            'description' => 'Thực phẩm tươi ngon, đồ uống chất lượng',
            'keywords' => ['thực phẩm', 'đồ uống', 'tươi sống', 'organic']
        ],
        'thu-cung' => [
            'category_id' => 22,
            'title' => 'Thú Cưng',
            'icon' => 'fas fa-paw',
            'description' => 'Sản phẩm chăm sóc thú cưng toàn diện',
            'keywords' => ['thú cưng', 'thức ăn chó mèo', 'đồ chơi thú cưng']
        ],
        'dung-cu-thiet-bi' => [
            'category_id' => 23,
            'title' => 'Dụng Cụ - Thiết Bị Tiện Ích',
            'icon' => 'fas fa-tools',
            'description' => 'Dụng cụ và thiết bị tiện ích cho gia đình',
            'keywords' => ['dụng cụ', 'thiết bị', 'sửa chữa', 'tiện ích']
        ],
        'van-phong-pham' => [
            'category_id' => 24,
            'title' => 'Văn Phòng Phẩm',
            'icon' => 'fas fa-graduation-cap',
            'description' => 'Văn phòng phẩm chất lượng cho học tập và làm việc',
            'keywords' => ['văn phong phẩm', 'học tập', 'bút', 'giấy']
        ],
        'cay-canh' => [
            'category_id' => 25,
            'title' => 'Cây Cảnh - Vườn',
            'icon' => 'fas fa-seedling',
            'description' => 'Cây cảnh và dụng cụ làm vườn xanh mát',
            'keywords' => ['cây cảnh', 'hoa', 'làm vườn', 'chậu cây']
        ],
        'qua-tang' => [
            'category_id' => 26,
            'title' => 'Quà Tặng',
            'icon' => 'fas fa-gift',
            'description' => 'Quà tặng ý nghĩa cho mọi dịp đặc biệt',
            'keywords' => ['quà tặng', 'lưu niệm', 'đặc biệt', 'kỷ niệm']
        ],
        'du-lich' => [
            'category_id' => 27,
            'title' => 'Du Lịch',
            'icon' => 'fas fa-plane',
            'description' => 'Phụ kiện và dụng cụ du lịch tiện dụng',
            'keywords' => ['du lịch', 'vali', 'phụ kiện du lịch']
        ],
        'gym' => [
            'category_id' => 28,
            'title' => 'Thể Thao - Gym',
            'icon' => 'fas fa-dumbbell',
            'description' => 'Thiết bị gym và thể thao chuyên nghiệp',
            'keywords' => ['gym', 'tập luyện', 'thể hình', 'fitness']
        ],
        'cau-ca' => [
            'category_id' => 29,
            'title' => 'Câu Cá',
            'icon' => 'fas fa-fish',
            'description' => 'Dụng cụ câu cá chuyên nghiệp và phụ kiện',
            'keywords' => ['câu cá', 'cần câu', 'lưỡi câu', 'fishing']
        ],
        'leo-nui' => [
            'category_id' => 30,
            'title' => 'Leo Núi - Trekking',
            'icon' => 'fas fa-mountain',
            'description' => 'Trang thiết bị leo núi và trekking an toàn',
            'keywords' => ['leo núi', 'trekking', 'phượt', 'outdoor']
        ],
        'boi-loi' => [
            'category_id' => 31,
            'title' => 'Bơi Lội',
            'icon' => 'fas fa-swimming-pool',
            'description' => 'Đồ bơi và phụ kiện bơi lội chất lượng',
            'keywords' => ['bơi lội', 'đồ bơi', 'kính bơi', 'swimming']
        ],
        'xe-dap-the-thao' => [
            'category_id' => 32,
            'title' => 'Xe Đạp Thể Thao',
            'icon' => 'fas fa-bicycle',
            'description' => 'Xe đạp thể thao và phụ kiện chuyên nghiệp',
            'keywords' => ['xe đạp', 'thể thao', 'đua xe', 'cycling']
        ],
        'tro-choi-tri-tue' => [
            'category_id' => 33,
            'title' => 'Trò Chơi Trí Tuệ',
            'icon' => 'fas fa-chess',
            'description' => 'Trò chơi phát triển trí tuệ và tư duy',
            'keywords' => ['trò chơi', 'trí tuệ', 'puzzle', 'board game']
        ],
        'nghe-thuat-thu-cong' => [
            'category_id' => 34,
            'title' => 'Nghệ Thuật - Thủ Công',
            'icon' => 'fas fa-paint-brush',
            'description' => 'Dụng cụ nghệ thuật và thủ công sáng tạo',
            'keywords' => ['nghệ thuật', 'thủ công', 'vẽ', 'handmade']
        ]
    ];

    /**
     * Hiển thị danh sách sản phẩm theo category
     */
    public function showCategory(Request $request, $categorySlug)
    {
        if (!isset($this->categoryConfig[$categorySlug])) {
            abort(404, 'Danh mục không tồn tại');
        }

        $config = $this->categoryConfig[$categorySlug];
        $categoryId = $config['category_id'];

        // Lấy sản phẩm từ bảng products theo category_id
        $query = Product::where('category_id', $categoryId)->where('status', 'active')->with('category');

        // Apply filters
        $filters = $this->applyFilters($query, $request, $categorySlug);
        
        // Apply sorting
        $this->applySorting($query, $request);

        // Pagination: 16 sản phẩm per page (4 sản phẩm x 4 hàng)
        $products = $query->paginate(16)->withQueryString();

        // Thống kê cho sidebar
        $categoryProducts = Product::where('category_id', $categoryId)->where('status', 'active');
        $totalProducts = $categoryProducts->count();
        $minPrice = $categoryProducts->min('price');
        $maxPrice = $categoryProducts->max('price');
        $avgPrice = $categoryProducts->avg('price');

        $stats = [
            'total_products' => (int) $totalProducts,
            'min_price' => $minPrice ? (float) $minPrice : 0,
            'max_price' => $maxPrice ? (float) $maxPrice : 0,
            'avg_price' => $avgPrice ? (float) $avgPrice : 0,
        ];

        // Get filter options for sidebar
        $filterOptions = $this->getFilterOptions($categorySlug);
        
        // Get price range
        $priceRange = $this->getPriceRange($categoryId);

        return view('categories.show', compact(
            'products', 
            'config', 
            'categorySlug', 
            'stats', 
            'filters', 
            'filterOptions', 
            'priceRange'
        ));
    }

    protected function applyFilters($query, $request, $categorySlug)
    {
        $appliedFilters = [];

        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
            $appliedFilters['search'] = $search;
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $minPrice = (float) $request->get('min_price');
            $query->where(function($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice)
                  ->orWhere(function($subQ) use ($minPrice) {
                      $subQ->whereNull('sale_price')
                           ->where('price', '>=', $minPrice);
                  });
            });
            $appliedFilters['min_price'] = $minPrice;
        }

        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->get('max_price');
            $query->where(function($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice)
                  ->orWhere(function($subQ) use ($maxPrice) {
                      $subQ->whereNull('sale_price')
                           ->where('price', '<=', $maxPrice);
                  });
            });
            $appliedFilters['max_price'] = $maxPrice;
        }

        // Stock filter
        if ($request->filled('in_stock') && $request->get('in_stock') == '1') {
            $query->where('stock_quantity', '>', 0);
            $appliedFilters['in_stock'] = true;
        }

        // Featured filter
        if ($request->filled('featured') && $request->get('featured') == '1') {
            $query->where('featured', true);
            $appliedFilters['featured'] = true;
        }

        // Sale filter
        if ($request->filled('on_sale') && $request->get('on_sale') == '1') {
            $query->whereNotNull('sale_price');
            $appliedFilters['on_sale'] = true;
        }

        // Category-specific filters
        $categoryFilters = $this->getCategorySpecificFilters($categorySlug, $request);
        $appliedFilters = array_merge($appliedFilters, $categoryFilters);
        
        // Apply category-specific filters to query
        $this->applyCategorySpecificFilters($query, $categoryFilters, $categorySlug);

        return $appliedFilters;
    }

    protected function applySorting($query, $request)
    {
        $sort = $request->get('sort', 'newest');

        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $query->orderBy('name', 'DESC');
                break;
            case 'popular':
                $query->orderBy('featured', 'DESC')
                      ->orderBy('created_at', 'DESC');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }
    }

    protected function getFilterOptions($categorySlug)
    {
        $options = [
            'sort_options' => [
                'newest' => 'Mới nhất',
                'popular' => 'Phổ biến',
                'price_asc' => 'Giá: Thấp đến cao',
                'price_desc' => 'Giá: Cao đến thấp',
                'name_asc' => 'Tên: A-Z',
                'name_desc' => 'Tên: Z-A',
            ]
        ];

        // Add category-specific filter options
        switch ($categorySlug) {
            case 'dien-thoai':
                $options['brands'] = ['Apple', 'Samsung', 'Xiaomi', 'OPPO', 'Vivo', 'Google', 'OnePlus', 'Nothing', 'Honor', 'Asus', 'Sony', 'Motorola'];
                $options['storage'] = ['64GB', '128GB', '256GB', '512GB', '1TB'];
                $options['price_ranges'] = [
                    ['min' => 0, 'max' => 10000000, 'label' => 'Dưới 10 triệu'],
                    ['min' => 10000000, 'max' => 20000000, 'label' => '10 - 20 triệu'],
                    ['min' => 20000000, 'max' => 30000000, 'label' => '20 - 30 triệu'],
                    ['min' => 30000000, 'max' => 999999999, 'label' => 'Trên 30 triệu'],
                ];
                break;

            case 'laptop':
                $options['brands'] = ['Apple', 'Dell', 'ASUS', 'HP', 'Lenovo', 'MSI', 'Acer', 'Razer', 'Gigabyte', 'LG', 'Surface'];
                $options['processors'] = ['Intel Core i3', 'Intel Core i5', 'Intel Core i7', 'Intel Core i9', 'AMD Ryzen 5', 'AMD Ryzen 7', 'Apple M2', 'Apple M3'];
                $options['ram'] = ['8GB', '16GB', '32GB', '64GB'];
                $options['storage'] = ['256GB SSD', '512GB SSD', '1TB SSD', '2TB SSD'];
                break;

            case 'sach':
                $options['categories'] = ['Kinh tế', 'Tâm lý', 'Kỹ năng sống', 'Tiểu thuyết', 'Khoa học viễn tưởng', 'Trinh thám', 'Phiêu lưu'];
                $options['authors'] = ['Dale Carnegie', 'Yuval Noah Harari', 'James Clear', 'Robert Kiyosaki', 'Adam Khoo'];
                $options['languages'] = ['Tiếng Việt', 'Tiếng Anh'];
                break;

            case 'me-be':
                $options['age_groups'] = ['0-6 tháng', '6-12 tháng', '1-2 tuổi', '2-3 tuổi', '3+ tuổi'];
                $options['categories'] = ['Xe đẩy', 'Ghế ngồi ô tô', 'Đồ chơi', 'Quần áo', 'Tã giấy', 'Sữa bột', 'Đồ dùng ăn uống'];
                $options['brands'] = ['Combi', 'Joie', 'Pampers', 'Huggies', 'Johnson\'s Baby', 'Pigeon', 'Chicco'];
                break;

            case 'thoi-trang-nu':
            case 'thoi-trang-nam':
                $options['sizes'] = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                $options['colors'] = ['Đen', 'Trắng', 'Xanh', 'Đỏ', 'Vàng', 'Hồng', 'Xám', 'Nâu'];
                $options['categories'] = ['Áo', 'Quần', 'Đầm', 'Chân váy', 'Áo khoác', 'Đồ thể thao', 'Đồ ngủ'];
                break;
        }

        return $options;
    }

    protected function getPriceRange($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('status', 'active')
            ->selectRaw('
                MIN(COALESCE(sale_price, price)) as min_price,
                MAX(COALESCE(sale_price, price)) as max_price
            ')
            ->first();

        return [
            'min' => $products->min_price ?? 0,
            'max' => $products->max_price ?? 1000000,
        ];
    }

    protected function getCategorySpecificFilters($categorySlug, $request)
    {
        $filters = [];

        switch ($categorySlug) {
            case 'dien-thoai':
                if ($request->filled('brand')) {
                    $filters['brand'] = $request->get('brand');
                }
                if ($request->filled('storage')) {
                    $filters['storage'] = $request->get('storage');
                }
                break;

            case 'laptop':
                if ($request->filled('brand')) {
                    $filters['brand'] = $request->get('brand');
                }
                if ($request->filled('processor')) {
                    $filters['processor'] = $request->get('processor');
                }
                if ($request->filled('ram')) {
                    $filters['ram'] = $request->get('ram');
                }
                break;

            case 'sach':
                if ($request->filled('author')) {
                    $filters['author'] = $request->get('author');
                }
                if ($request->filled('language')) {
                    $filters['language'] = $request->get('language');
                }
                break;

            case 'me-be':
                if ($request->filled('age_group')) {
                    $filters['age_group'] = $request->get('age_group');
                }
                if ($request->filled('brand')) {
                    $filters['brand'] = $request->get('brand');
                }
                break;

            case 'thoi-trang-nu':
            case 'thoi-trang-nam':
                if ($request->filled('size')) {
                    $filters['size'] = $request->get('size');
                }
                if ($request->filled('color')) {
                    $filters['color'] = $request->get('color');
                }
                break;
        }

        return $filters;
    }

    protected function applyCategorySpecificFilters($query, $filters, $categorySlug)
    {
        // For now, we'll use simple name/description matching
        // In a real application, you'd have separate attributes/tags tables
        
        foreach ($filters as $key => $value) {
            if ($value) {
                $query->where(function($q) use ($value) {
                    $q->where('name', 'LIKE', "%{$value}%")
                      ->orWhere('description', 'LIKE', "%{$value}%");
                });
            }
        }
    }

    /**
     * Lấy danh sách tất cả categories
     */
    public function getAllCategories()
    {
        return $this->categoryConfig;
    }

    /**
     * Lấy thông tin một category
     */
    public function getCategoryConfig($slug)
    {
        return $this->categoryConfig[$slug] ?? null;
    }
}