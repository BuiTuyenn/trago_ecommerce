# Product Filter Component

Bộ lọc sản phẩm có thể tái sử dụng cho Laravel Blade với đầy đủ tính năng.

## 📁 Cấu trúc Files

```
resources/views/components/
├── product-filter.blade.php          # Blade component
└── README-product-filter.md           # Tài liệu này

resources/css/components/
└── product-filter.css                 # CSS styles

public/css/components/
└── product-filter.css                 # CSS public (được copy)

public/js/components/
└── product-filter.js                  # JavaScript functionality

resources/views/products/
└── index-with-component.blade.php     # Example usage - Products page

resources/views/categories/
└── show-with-component.blade.php      # Example usage - Category page
```

## 🚀 Cách sử dụng

### 1. Sử dụng cơ bản
```blade
<x-product-filter />
```

### 2. Sử dụng với tùy chỉnh
```blade
<x-product-filter 
    :action="route('products.index')"
    headerTitle="Bộ lọc sản phẩm"
    headerBg="bg-primary"
    :resetRoute="route('products.index')"
    :showQuickFilter="true"
    :enableAutoSubmit="true"
    :filterParams="['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'sort']"
/>
```

### 3. Cho trang Category
```blade
<x-product-filter 
    :action="request()->url()"
    headerTitle="Bộ lọc thông minh"
    headerBg="bg-success"
    :resetRoute="route('category.' . $categorySlug)"
    :showQuickFilter="true"
    :enableAutoSubmit="true"
    :filterParams="['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'brand', 'sort']"
/>
```

## 📝 Props/Parameters

| Prop | Type | Default | Mô tả |
|------|------|---------|-------|
| `action` | string | `route('products.index')` | URL để submit form |
| `headerTitle` | string | `'Bộ lọc sản phẩm'` | Tiêu đề header |
| `headerBg` | string | `'bg-primary'` | CSS class cho background header |
| `resetRoute` | string | `route('products.index')` | Route để reset filters |
| `showQuickFilter` | boolean | `true` | Hiển thị nút Quick Filter |
| `enableAutoSubmit` | boolean | `true` | Tự động submit khi thay đổi sort |
| `filterParams` | array | `['search', 'min_price', ...]` | Danh sách params để tracking |

## 🎯 Tính năng

### ✅ Row 1 - Basic Filters
- **Search**: Tìm kiếm sản phẩm theo tên, mô tả
- **Price Range**: Khoảng giá tùy chỉnh (từ - đến)
- **Stock Status**: Tình trạng kho hàng
- **Filter Button**: Nút submit form

### ✅ Row 2 - Advanced Filters
- **Sort**: Sắp xếp theo tên, giá, ngày tạo, etc.
- **Product Type**: Loại sản phẩm (Mới, Sale, Nổi bật, Bán chạy)
- **Price Range Presets**: Mức giá có sẵn
- **Rating Filter**: Lọc theo đánh giá

### ✅ JavaScript Features
- **Collapsible Filter**: Thu gọn/mở rộng
- **Price Range Sync**: Đồng bộ preset và custom input
- **Quick Filter Modal**: Bộ lọc nhanh
- **Auto Submit**: Tự động submit khi thay đổi sort
- **Filter Count Badge**: Hiển thị số filter đang active
- **Search Debounce**: Tự động search sau 500ms

## 🎨 CSS Classes

### Main Classes
```css
.product-filter-card        # Container chính
.product-filter-card .card-header    # Header section
.product-filter-card .card-body      # Body section
```

### Responsive
- **Desktop**: 6 cột mỗi hàng
- **Tablet**: 3-4 cột mỗi hàng
- **Mobile**: 1-2 cột mỗi hàng

## ⚙️ JavaScript API

### Khởi tạo
```javascript
// Tự động khởi tạo khi có .product-filter-card
window.productFilter = new ProductFilter();

// Hoặc khởi tạo với options
window.productFilter = new ProductFilter({
    enableAutoSubmit: false,
    filterParams: ['search', 'price'],
    quickFilters: [
        { text: 'Sản phẩm mới', field: 'product_type', value: 'new' }
    ]
});
```

### Methods
```javascript
// Lấy filter values hiện tại
const filters = productFilter.getCurrentFilters();

// Set filter values
productFilter.setFilters({
    search: 'laptop',
    min_price: '1000000'
});

// Reset tất cả filters
productFilter.resetFilters();

// Show/hide loading state
productFilter.showLoading(true);

// Update filter count
productFilter.updateFilterCount();
```

## 🔧 Cài đặt

### 1. Copy files đã tạo
```bash
# CSS đã được copy tự động
# JS đã được tạo sẵn
```

### 2. Include trong layout
```blade
<!-- Trong app.blade.php hoặc layout chính -->
@stack('styles')  <!-- Để component tự include CSS -->
@stack('scripts') <!-- Để component tự include JS -->
```

### 3. Ensure Bootstrap
Component yêu cầu Bootstrap 5 cho:
- Grid system
- Form controls  
- Modal
- Collapse

## 📋 Examples

### Thay thế trang Products hiện tại
1. Backup: `products/index.blade.php` → `products/index-old.blade.php`
2. Copy: `products/index-with-component.blade.php` → `products/index.blade.php`

### Thay thế trang Category hiện tại  
1. Backup: `categories/show.blade.php` → `categories/show-old.blade.php`
2. Copy: `categories/show-with-component.blade.php` → `categories/show.blade.php`

## 🐛 Troubleshooting

### CSS không load
```blade
<!-- Manual include trong head -->
<link rel="stylesheet" href="{{ asset('css/components/product-filter.css') }}">
```

### JS không hoạt động
```blade
<!-- Manual include trước </body> -->
<script src="{{ asset('js/components/product-filter.js') }}"></script>
```

### Bootstrap Modal không hoạt động
```javascript
// Ensure Bootstrap JS được load
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
```

## 🎯 Customization

### Custom Quick Filters
```blade
<x-product-filter 
    :quickFilters="[
        ['text' => 'Laptop Gaming', 'field' => 'search', 'value' => 'gaming'],
        ['text' => 'Dưới 10 triệu', 'field' => 'max_price', 'value' => '10000000']
    ]"
/>
```

### Custom Styling
```css
/* Override trong CSS riêng */
.product-filter-card.custom-theme {
    border-color: #your-color;
}

.product-filter-card.custom-theme .card-header {
    background: linear-gradient(45deg, #color1, #color2);
}
```

## 📈 Performance

- **CSS**: ~15KB (minified)
- **JS**: ~12KB (minified)  
- **Zero dependencies** (chỉ cần Bootstrap)
- **Mobile-first** responsive design
- **Lazy loading** cho modal

## 🔄 Maintenance

### Update CSS
1. Sửa: `resources/css/components/product-filter.css`
2. Copy: `copy "resources\css\components\product-filter.css" "public\css\components\product-filter.css"`

### Update JS
1. Sửa: `public/js/components/product-filter.js`
2. Clear cache: `php artisan view:clear`

---
**Created**: 2025-09-21  
**Version**: 1.0.0  
**Author**: AI Assistant
