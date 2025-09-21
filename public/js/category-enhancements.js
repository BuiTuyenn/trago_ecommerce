/**
 * Category Page Enhancements
 * JavaScript functionality for category pages
 */

document.addEventListener('DOMContentLoaded', function() {
    initCategoryEnhancements();
});

function initCategoryEnhancements() {
    // Initialize all enhancement features
    initBackToTop();
    initToastNotifications();
    initProductQuickView();
    initProductCompare();
    initFilterPills();
    initLoadingStates();
    initScrollAnimations();
    initImageLazyLoading();
}

// Back to Top Button
function initBackToTop() {
    // Create back to top button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    backToTopBtn.setAttribute('aria-label', 'Về đầu trang');
    document.body.appendChild(backToTopBtn);

    // Show/hide based on scroll position
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });

    // Smooth scroll to top
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Toast Notifications System
function initToastNotifications() {
    // Create toast container if it doesn't exist
    if (!document.querySelector('.toast-container')) {
        const container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
}

function showToast(message, type = 'info', duration = 5000) {
    const container = document.querySelector('.toast-container');
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    
    const iconMap = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };

    toast.innerHTML = `
        <div class="toast-content">
            <i class="toast-icon ${iconMap[type] || iconMap.info}"></i>
            <span class="toast-message">${message}</span>
            <button class="toast-close" aria-label="Đóng">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    container.appendChild(toast);

    // Close button functionality
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => removeToast(toast));

    // Auto remove after duration
    setTimeout(() => removeToast(toast), duration);

    // Add click to close
    toast.addEventListener('click', () => removeToast(toast));
}

function removeToast(toast) {
    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

// Product Quick View
function initProductQuickView() {
    // Add quick view buttons to product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const quickViewBtn = document.createElement('button');
        quickViewBtn.className = 'btn btn-outline-primary btn-sm quick-view-btn';
        quickViewBtn.innerHTML = '<i class="fas fa-eye me-1"></i>Xem nhanh';
        quickViewBtn.style.cssText = `
            position: absolute;
            top: 15px;
            right: 15px;
            opacity: 0;
            transition: var(--transition);
            z-index: 2;
        `;
        
        card.style.position = 'relative';
        card.appendChild(quickViewBtn);
        
        // Show/hide on hover
        card.addEventListener('mouseenter', () => {
            quickViewBtn.style.opacity = '1';
        });
        
        card.addEventListener('mouseleave', () => {
            quickViewBtn.style.opacity = '0';
        });
        
        // Quick view functionality
        quickViewBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            openQuickView(card);
        });
    });
}

function openQuickView(productCard) {
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'quick-view-modal';
    
    const productName = productCard.querySelector('.product-title a').textContent;
    const productImage = productCard.querySelector('.product-image img')?.src || '';
    const productPrice = productCard.querySelector('.current-price').textContent;
    
    modal.innerHTML = `
        <div class="quick-view-content">
            <button class="quick-view-close" aria-label="Đóng">
                <i class="fas fa-times"></i>
            </button>
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="product-zoom">
                        <img src="${productImage}" alt="${productName}" class="img-fluid">
                        <div class="zoom-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-4">
                    <h3 class="mb-3">${productName}</h3>
                    <div class="price-info mb-3">
                        <span class="h4 text-danger">${productPrice}</span>
                    </div>
                    <div class="product-actions">
                        <button class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </button>
                        <button class="btn btn-outline-danger w-100">
                            <i class="fas fa-heart me-2"></i>Yêu thích
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Show modal
    setTimeout(() => modal.classList.add('active'), 10);
    
    // Close functionality
    const closeBtn = modal.querySelector('.quick-view-close');
    closeBtn.addEventListener('click', () => closeQuickView(modal));
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeQuickView(modal);
        }
    });
    
    // ESC key to close
    const escHandler = (e) => {
        if (e.key === 'Escape') {
            closeQuickView(modal);
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

function closeQuickView(modal) {
    modal.classList.remove('active');
    setTimeout(() => {
        if (modal.parentNode) {
            modal.parentNode.removeChild(modal);
        }
    }, 300);
}

// Product Compare System
let compareProducts = JSON.parse(localStorage.getItem('compareProducts') || '[]');

function initProductCompare() {
    // Add compare checkboxes to product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        const compareCheckbox = document.createElement('div');
        compareCheckbox.className = 'compare-checkbox';
        compareCheckbox.style.cssText = `
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255,255,255,0.9);
            border-radius: 4px;
            padding: 4px;
            opacity: 0;
            transition: var(--transition);
            z-index: 2;
        `;
        
        compareCheckbox.innerHTML = `
            <input type="checkbox" id="compare-${index}" data-product-id="${index}">
            <label for="compare-${index}" style="margin: 0; cursor: pointer;">
                <i class="fas fa-balance-scale" style="font-size: 0.8rem;"></i>
            </label>
        `;
        
        card.appendChild(compareCheckbox);
        
        // Show/hide on hover
        card.addEventListener('mouseenter', () => {
            compareCheckbox.style.opacity = '1';
        });
        
        card.addEventListener('mouseleave', () => {
            compareCheckbox.style.opacity = '0';
        });
        
        // Compare functionality
        const checkbox = compareCheckbox.querySelector('input');
        checkbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                addToCompare(index, card);
            } else {
                removeFromCompare(index);
            }
        });
    });
    
    // Initialize compare bar if products exist
    if (compareProducts.length > 0) {
        showCompareBar();
    }
}

function addToCompare(productId, productCard) {
    if (compareProducts.length >= 3) {
        showToast('Chỉ có thể so sánh tối đa 3 sản phẩm', 'warning');
        productCard.querySelector('input[type="checkbox"]').checked = false;
        return;
    }
    
    const productName = productCard.querySelector('.product-title a').textContent;
    const productImage = productCard.querySelector('.product-image img')?.src || '';
    
    compareProducts.push({
        id: productId,
        name: productName,
        image: productImage
    });
    
    localStorage.setItem('compareProducts', JSON.stringify(compareProducts));
    showCompareBar();
    showToast('Đã thêm sản phẩm vào danh sách so sánh', 'success');
}

function removeFromCompare(productId) {
    compareProducts = compareProducts.filter(p => p.id !== productId);
    localStorage.setItem('compareProducts', JSON.stringify(compareProducts));
    
    if (compareProducts.length === 0) {
        hideCompareBar();
    } else {
        updateCompareBar();
    }
    
    showToast('Đã xóa sản phẩm khỏi danh sách so sánh', 'info');
}

function showCompareBar() {
    let compareBar = document.querySelector('.compare-bar');
    
    if (!compareBar) {
        compareBar = document.createElement('div');
        compareBar.className = 'compare-bar';
        document.body.appendChild(compareBar);
    }
    
    updateCompareBar();
    compareBar.classList.add('active');
}

function updateCompareBar() {
    const compareBar = document.querySelector('.compare-bar');
    if (!compareBar) return;
    
    compareBar.innerHTML = `
        <div class="compare-content">
            <div class="compare-products">
                ${compareProducts.map(product => `
                    <div class="compare-product">
                        <img src="${product.image}" alt="${product.name}">
                        <span>${product.name.substring(0, 20)}...</span>
                    </div>
                `).join('')}
            </div>
            <div class="compare-actions">
                <button class="btn-compare">
                    So sánh (${compareProducts.length})
                </button>
                <button class="btn-clear-compare">
                    Xóa tất cả
                </button>
            </div>
        </div>
    `;
    
    // Add event listeners
    compareBar.querySelector('.btn-compare').addEventListener('click', () => {
        showToast('Tính năng so sánh sẽ được phát triển', 'info');
    });
    
    compareBar.querySelector('.btn-clear-compare').addEventListener('click', () => {
        clearCompare();
    });
}

function hideCompareBar() {
    const compareBar = document.querySelector('.compare-bar');
    if (compareBar) {
        compareBar.classList.remove('active');
    }
}

function clearCompare() {
    compareProducts = [];
    localStorage.removeItem('compareProducts');
    hideCompareBar();
    
    // Uncheck all compare checkboxes
    document.querySelectorAll('.compare-checkbox input').forEach(cb => {
        cb.checked = false;
    });
    
    showToast('Đã xóa tất cả sản phẩm khỏi danh sách so sánh', 'info');
}

// Filter Pills
function initFilterPills() {
    const filterForm = document.querySelector('.filter-form');
    if (!filterForm) return;
    
    // Create filter pills container
    const pillsContainer = document.createElement('div');
    pillsContainer.className = 'filter-pills';
    filterForm.parentNode.insertBefore(pillsContainer, filterForm.nextSibling);
    
    // Update pills when form changes
    filterForm.addEventListener('input', updateFilterPills);
    updateFilterPills();
}

function updateFilterPills() {
    const pillsContainer = document.querySelector('.filter-pills');
    if (!pillsContainer) return;
    
    pillsContainer.innerHTML = '';
    
    const urlParams = new URLSearchParams(window.location.search);
    
    // Add active filters as pills
    urlParams.forEach((value, key) => {
        if (value && key !== 'page' && key !== '_token') {
            const pill = document.createElement('div');
            pill.className = 'filter-pill active';
            
            let label = key;
            if (key === 'search') label = 'Tìm kiếm';
            if (key === 'min_price') label = 'Giá từ';
            if (key === 'max_price') label = 'Giá đến';
            if (key === 'sort') label = 'Sắp xếp';
            
            pill.innerHTML = `
                <span>${label}: ${value}</span>
                <button class="remove-filter" data-filter="${key}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            pillsContainer.appendChild(pill);
            
            // Remove filter functionality
            pill.querySelector('.remove-filter').addEventListener('click', () => {
                removeFilter(key);
            });
        }
    });
}

function removeFilter(filterKey) {
    const url = new URL(window.location);
    url.searchParams.delete(filterKey);
    window.location.href = url.toString();
}

// Loading States
function initLoadingStates() {
    // Show loading skeleton when filtering
    const filterForm = document.querySelector('.filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', showLoadingSkeleton);
    }
    
    // Show loading when clicking pagination
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', showLoadingSkeleton);
    });
}

function showLoadingSkeleton() {
    const productsGrid = document.querySelector('.products-grid');
    if (!productsGrid) return;
    
    // Add loading class
    document.body.classList.add('loading');
    
    // Create skeleton cards
    const skeletonHTML = Array(12).fill().map(() => `
        <div class="skeleton-product-card">
            <div class="skeleton-product-image loading-skeleton"></div>
            <div class="skeleton-product-title loading-skeleton"></div>
            <div class="skeleton-product-price loading-skeleton"></div>
            <div class="skeleton-product-rating loading-skeleton"></div>
            <div class="skeleton-product-button loading-skeleton"></div>
        </div>
    `).join('');
    
    productsGrid.innerHTML = skeletonHTML;
}

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);
    
    // Observe product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });
}

// Image Lazy Loading
function initImageLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Export functions for external use
window.CategoryEnhancements = {
    showToast,
    addToCompare,
    removeFromCompare,
    clearCompare,
    openQuickView,
    showLoadingSkeleton
};
