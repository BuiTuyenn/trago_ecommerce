/* ========================================
   HOME & LIVING PAGE JAVASCRIPT
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize category page functionality
    initCategoryPage();
    // Initialize advanced filters
    initAdvancedFilters();
});

function initCategoryPage() {
    initSortFunctionality();
    initPriceFilter();
    initTagFilters();
    initProductHover();
    initStickyFilters();
}

/* ========================================
   SORT FUNCTIONALITY
   ======================================== */

function initSortFunctionality() {
    const sortSelect = document.getElementById('sortProducts');
    if (!sortSelect) return;

    // Set current sort value from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentSort = urlParams.get('sort');
    if (currentSort) {
        sortSelect.value = currentSort;
    }

    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        updateUrlParameter('sort', sortValue);
    });
}

/* ========================================
   PRICE FILTER FUNCTIONALITY
   ======================================== */

function initPriceFilter() {
    const priceFilter = document.getElementById('priceFilter');
    if (!priceFilter) return;

    // Set current filter values from URL
    const urlParams = new URLSearchParams(window.location.search);
    const minPrice = urlParams.get('min_price');
    const maxPrice = urlParams.get('max_price');
    
    if (minPrice) {
        priceFilter.querySelector('input[name="min_price"]').value = minPrice;
    }
    if (maxPrice) {
        priceFilter.querySelector('input[name="max_price"]').value = maxPrice;
    }

    priceFilter.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const minPrice = this.querySelector('input[name="min_price"]').value;
        const maxPrice = this.querySelector('input[name="max_price"]').value;
        
        const url = new URL(window.location);
        
        // Remove existing price parameters
        url.searchParams.delete('min_price');
        url.searchParams.delete('max_price');
        
        // Add new price parameters if they exist
        if (minPrice && minPrice.trim() !== '') {
            url.searchParams.set('min_price', minPrice);
        }
        if (maxPrice && maxPrice.trim() !== '') {
            url.searchParams.set('max_price', maxPrice);
        }
        
        // Reset to first page
        url.searchParams.delete('page');
        
        window.location.href = url.toString();
    });

    // Clear price filter
    const clearPriceBtn = document.getElementById('clearPriceFilter');
    if (clearPriceBtn) {
        clearPriceBtn.addEventListener('click', function() {
            priceFilter.querySelector('input[name="min_price"]').value = '';
            priceFilter.querySelector('input[name="max_price"]').value = '';
            
            const url = new URL(window.location);
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');
            url.searchParams.delete('page');
            
            window.location.href = url.toString();
        });
    }
}

/* ========================================
   TAG FILTER FUNCTIONALITY
   ======================================== */

function initTagFilters() {
    document.querySelectorAll('.tag-badge').forEach(tag => {
        tag.addEventListener('click', function() {
            const tagText = this.textContent.trim();
            
            // Toggle active state
            this.classList.toggle('active');
            
            // Get current active tags
            const activeTags = Array.from(document.querySelectorAll('.tag-badge.active'))
                .map(tag => tag.textContent.trim());
            
            updateUrlParameter('tags', activeTags.join(','));
        });
    });

    // Set active tags from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentTags = urlParams.get('tags');
    if (currentTags) {
        const tagsList = currentTags.split(',');
        document.querySelectorAll('.tag-badge').forEach(tag => {
            if (tagsList.includes(tag.textContent.trim())) {
                tag.classList.add('active');
            }
        });
    }
}

/* ========================================
   PRODUCT HOVER EFFECTS
   ======================================== */

function initProductHover() {
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

/* ========================================
   STICKY FILTERS
   ======================================== */

function initStickyFilters() {
    const sidebar = document.querySelector('.bookstore-sidebar');
    if (!sidebar) return;

    let sidebarTop = sidebar.offsetTop;
    
    function handleScroll() {
        if (window.pageYOffset >= sidebarTop - 20) {
            sidebar.style.position = 'fixed';
            sidebar.style.top = '20px';
            sidebar.style.width = sidebar.parentElement.offsetWidth + 'px';
        } else {
            sidebar.style.position = 'static';
            sidebar.style.width = 'auto';
        }
    }

    // Only apply sticky on desktop
    if (window.innerWidth > 991) {
        window.addEventListener('scroll', handleScroll);
    }
    
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 991) {
            window.removeEventListener('scroll', handleScroll);
            sidebar.style.position = 'static';
            sidebar.style.width = 'auto';
        } else {
            sidebarTop = sidebar.offsetTop;
            window.addEventListener('scroll', handleScroll);
        }
    });
}

/* ========================================
   UTILITY FUNCTIONS
   ======================================== */

function updateUrlParameter(key, value) {
    const url = new URL(window.location);
    
    if (value && value !== '') {
        url.searchParams.set(key, value);
    } else {
        url.searchParams.delete(key);
    }
    
    // Reset to first page when filtering
    if (key !== 'page') {
        url.searchParams.delete('page');
    }
    
    window.location.href = url.toString();
}

function showLoading() {
    const loadingHtml = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="mt-3 text-muted">Đang tải sản phẩm...</p>
        </div>
    `;
    
    const productsGrid = document.querySelector('.products-grid');
    if (productsGrid) {
        productsGrid.innerHTML = loadingHtml;
    }
}

/* ========================================
   ADVANCED FILTER SYSTEM
   ======================================== */

function initAdvancedFilters() {
    // Filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filterType = this.dataset.filter;
            filterProducts(filterType);
        });
    });

    // Material filter buttons
    const matBtns = document.querySelectorAll('.mat-btn');
    matBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            matBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const material = this.dataset.material;
            filterByMaterial(material);
        });
    });

    // Price range filter
    const priceSelect = document.querySelector('.price-select');
    if (priceSelect) {
        priceSelect.addEventListener('change', function() {
            const priceRange = this.value;
            filterByPrice(priceRange);
        });
    }

    // Brand filter
    const brandSelect = document.querySelector('.brand-select');
    if (brandSelect) {
        brandSelect.addEventListener('change', function() {
            const brand = this.value;
            filterByBrand(brand);
        });
    }

    // Sort select
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortType = this.value;
            sortProducts(sortType);
        });
    }

    // Reset filter button
    const resetBtn = document.querySelector('.btn-reset-filter');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            resetAllFilters();
        });
    }

    // Apply filter button
    const applyBtn = document.querySelector('.btn-apply-filter');
    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            applyFilters();
        });
    }
}

function filterProducts(filterType) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        let shouldShow = true;
        
        switch(filterType) {
            case 'all':
                shouldShow = true;
                break;
            case 'bestseller':
                shouldShow = product.getAttribute('data-bestseller') === 'true';
                break;
            case 'featured':
                shouldShow = product.getAttribute('data-featured') === 'true';
                break;
            case 'freeship':
                shouldShow = product.querySelector('.featured-badge') !== null;
                break;
        }
        
        if (shouldShow) {
            product.style.display = 'block';
            product.style.animation = 'fadeIn 0.3s ease';
        } else {
            product.style.display = 'none';
        }
    });
    
    updateResultsCount();
}

function filterByMaterial(material) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        let shouldShow = true;
        
        if (material !== 'all') {
            // Simulate material detection based on title
            const title = product.querySelector('.product-title').textContent.toLowerCase();
            
            if (material === 'wood') {
                shouldShow = title.includes('gỗ') || title.includes('wood') || title.includes('nội thất');
            } else if (material === 'metal') {
                shouldShow = title.includes('kim loại') || title.includes('metal') || title.includes('thép');
            } else if (material === 'plastic') {
                shouldShow = title.includes('nhựa') || title.includes('plastic');
            }
        }
        
        product.style.display = shouldShow ? 'block' : 'none';
    });
    
    updateResultsCount();
}

function filterByBrand(brand) {
    if (!brand) {
        document.querySelectorAll('.product-card').forEach(product => {
            product.style.display = 'block';
        });
        updateResultsCount();
        return;
    }
    
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productBrand = product.querySelector('.product-brand').textContent;
        const shouldShow = productBrand.includes(brand);
        
        product.style.display = shouldShow ? 'block' : 'none';
    });
    
    updateResultsCount();
}

function filterByPrice(priceRange) {
    if (!priceRange) {
        document.querySelectorAll('.product-card').forEach(product => {
            product.style.display = 'block';
        });
        updateResultsCount();
        return;
    }
    
    const [min, max] = priceRange.split('-').map(Number);
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const priceText = product.querySelector('.current-price').textContent;
        const price = parseInt(priceText.replace(/[^\d]/g, ''));
        
        const shouldShow = price >= min && price <= max;
        product.style.display = shouldShow ? 'block' : 'none';
    });
    
    updateResultsCount();
}

function sortProducts(sortType) {
    const productsContainer = document.querySelector('.products-grid');
    const products = Array.from(document.querySelectorAll('.product-card'));
    
    products.sort((a, b) => {
        switch(sortType) {
            case 'price_asc':
                const priceA = parseInt(a.querySelector('.current-price').textContent.replace(/[^\d]/g, ''));
                const priceB = parseInt(b.querySelector('.current-price').textContent.replace(/[^\d]/g, ''));
                return priceA - priceB;
            
            case 'price_desc':
                const priceA2 = parseInt(a.querySelector('.current-price').textContent.replace(/[^\d]/g, ''));
                const priceB2 = parseInt(b.querySelector('.current-price').textContent.replace(/[^\d]/g, ''));
                return priceB2 - priceA2;
            
            case 'discount':
                const discountA = a.querySelector('.discount-badge') ? 
                    parseInt(a.querySelector('.discount-badge').textContent.replace(/[^\d]/g, '')) : 0;
                const discountB = b.querySelector('.discount-badge') ? 
                    parseInt(b.querySelector('.discount-badge').textContent.replace(/[^\d]/g, '')) : 0;
                return discountB - discountA;
            
            default:
                return 0;
        }
    });
    
    products.forEach(product => {
        productsContainer.appendChild(product);
    });
    
    showFilterMessage(`Đã sắp xếp theo ${getSortLabel(sortType)}`);
}

function resetAllFilters() {
    // Reset filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector('.filter-btn[data-filter="all"]')?.classList.add('active');
    
    // Reset material buttons
    document.querySelectorAll('.mat-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector('.mat-btn[data-material="all"]')?.classList.add('active');
    
    // Reset select boxes
    const priceSelect = document.querySelector('.price-select');
    if (priceSelect) priceSelect.value = '';
    
    const brandSelect = document.querySelector('.brand-select');
    if (brandSelect) brandSelect.value = '';
    
    const sortSelect = document.querySelector('.sort-select');
    if (sortSelect) sortSelect.value = 'popular';
    
    // Show all products
    document.querySelectorAll('.product-card').forEach(product => {
        product.style.display = 'block';
    });
    
    updateResultsCount();
    showFilterMessage('Đã xóa tất cả bộ lọc');
}

function applyFilters() {
    const applyBtn = document.querySelector('.btn-apply-filter');
    if (!applyBtn) return;
    
    const originalText = applyBtn.innerHTML;
    
    applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lọc...';
    applyBtn.disabled = true;
    
    setTimeout(() => {
        applyBtn.innerHTML = originalText;
        applyBtn.disabled = false;
        showFilterMessage('Đã áp dụng bộ lọc thành công!');
    }, 800);
}

function updateResultsCount() {
    const visibleProducts = document.querySelectorAll('.product-card[style*="display: block"], .product-card:not([style*="display: none"])').length;
    const countElement = document.querySelector('.count-number');
    
    if (countElement) {
        countElement.textContent = visibleProducts;
        countElement.style.transform = 'scale(1.2)';
        setTimeout(() => {
            countElement.style.transform = 'scale(1)';
        }, 200);
    }
}

function showFilterMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4caf50;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        font-size: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    `;
    messageDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

function getSortLabel(sortType) {
    const labels = {
        'popular': 'phổ biến nhất',
        'newest': 'mới nhất',
        'bestseller': 'bán chạy nhất',
        'price_asc': 'giá thấp → cao',
        'price_desc': 'giá cao → thấp',
        'rating': 'đánh giá cao',
        'discount': 'giảm giá nhiều'
    };
    
    return labels[sortType] || 'mặc định';
}

/* ========================================
   AJAX PRODUCT LOADING (Optional Enhancement)
   ======================================== */

function loadProductsAjax(params = {}) {
    showLoading();
    
    const url = new URL(window.location);
    Object.keys(params).forEach(key => {
        if (params[key]) {
            url.searchParams.set(key, params[key]);
        } else {
            url.searchParams.delete(key);
        }
    });
    
    fetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Parse the response and update only the products grid
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newProductsGrid = doc.querySelector('.products-grid');
        const newPagination = doc.querySelector('.pagination');
        
        if (newProductsGrid) {
            document.querySelector('.products-grid').innerHTML = newProductsGrid.innerHTML;
        }
        
        if (newPagination) {
            const paginationContainer = document.querySelector('.pagination').parentElement;
            paginationContainer.innerHTML = newPagination.parentElement.innerHTML;
        }
        
        // Re-initialize product hover effects
        initProductHover();
        
        // Update URL without reload
        history.pushState(null, '', url.toString());
    })
    .catch(error => {
        console.error('Error loading products:', error);
        // Fall back to normal page reload
        window.location.href = url.toString();
    });
}

/* ========================================
   EXPORT FOR GLOBAL USE
   ======================================== */

window.homeLivingPage = {
    updateUrlParameter,
    loadProductsAjax,
    showLoading,
    filterProducts,
    filterByPrice,
    filterByBrand,
    filterByMaterial,
    sortProducts,
    resetAllFilters
};