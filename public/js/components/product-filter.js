/**
 * Product Filter Component JavaScript
 * Handles all filter interactions and behaviors
 */

class ProductFilter {
    constructor(options = {}) {
        this.options = {
            enableAutoSubmit: true,
            filterParams: ['search', 'min_price', 'max_price', 'stock_status', 'product_type', 'price_range', 'rating', 'sort'],
            autoSubmitSelects: ['sort'],
            quickFilters: [
                { text: 'Sản phẩm mới', field: 'product_type', value: 'new' },
                { text: 'Đang giảm giá', field: 'product_type', value: 'sale' },
                { text: 'Sản phẩm nổi bật', field: 'product_type', value: 'featured' },
                { text: 'Còn hàng', field: 'stock_status', value: 'in_stock' },
                { text: 'Dưới 500k', field: 'price_range', value: '100k_500k' },
                { text: '1-5 triệu', field: 'price_range', value: '1m_5m' }
            ],
            ...options
        };
        
        this.init();
    }

    init() {
        this.setupCollapsibleFilter();
        this.setupPriceRangeHandler();
        this.setupQuickFilter();
        this.setupAutoSubmit();
        this.updateFilterCount();
        this.setupSearchDebounce();
    }

    /**
     * Setup collapsible filter toggle
     */
    setupCollapsibleFilter() {
        const filterCollapse = document.getElementById('filterCollapse');
        const toggleIcon = document.getElementById('filterToggleIcon');
        
        if (filterCollapse && toggleIcon) {
            filterCollapse.addEventListener('show.bs.collapse', () => {
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-up');
            });
            
            filterCollapse.addEventListener('hide.bs.collapse', () => {
                toggleIcon.classList.remove('fa-chevron-up');
                toggleIcon.classList.add('fa-chevron-down');
            });
        }
    }

    /**
     * Setup price range preset handler
     */
    setupPriceRangeHandler() {
        const priceRangeSelect = document.getElementById('price_range');
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        if (priceRangeSelect) {
            priceRangeSelect.addEventListener('change', (e) => {
                const value = e.target.value;
                this.applyPriceRange(value, minPriceInput, maxPriceInput);
            });
        }

        // Clear price range preset when custom values are entered
        if (minPriceInput || maxPriceInput) {
            [minPriceInput, maxPriceInput].forEach(input => {
                if (input) {
                    input.addEventListener('input', () => {
                        if (priceRangeSelect) {
                            priceRangeSelect.value = '';
                        }
                    });
                }
            });
        }
    }

    /**
     * Apply price range preset values
     */
    applyPriceRange(value, minInput, maxInput) {
        const ranges = {
            'under_100k': { min: '', max: '100000' },
            '100k_500k': { min: '100000', max: '500000' },
            '500k_1m': { min: '500000', max: '1000000' },
            '1m_5m': { min: '1000000', max: '5000000' },
            '5m_10m': { min: '5000000', max: '10000000' },
            'over_10m': { min: '10000000', max: '' }
        };

        if (ranges[value]) {
            if (minInput) minInput.value = ranges[value].min;
            if (maxInput) maxInput.value = ranges[value].max;
        }
    }

    /**
     * Setup quick filter functionality
     */
    setupQuickFilter() {
        const quickFilterBtns = document.querySelectorAll('#quickFilterBtn, #quickFilterBtn2');
        
        quickFilterBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', () => {
                    this.showQuickFilterModal();
                });
            }
        });
    }

    /**
     * Show quick filter modal
     */
    showQuickFilterModal() {
        let modalHtml = `
            <div class="modal fade quick-filter-modal" id="quickFilterModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-magic me-2"></i>Bộ lọc nhanh
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
        `;
        
        this.options.quickFilters.forEach((filter, index) => {
            modalHtml += `
                <div class="col-6">
                    <button type="button" class="btn btn-outline-primary w-100 quick-filter-btn" 
                            data-field="${filter.field}" data-value="${filter.value}">
                        ${filter.text}
                    </button>
                </div>
            `;
        });
        
        modalHtml += `
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal
        const existingModal = document.getElementById('quickFilterModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add new modal
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Setup quick filter button clicks
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const field = e.target.dataset.field;
                const value = e.target.dataset.value;
                this.applyQuickFilter(field, value);
            });
        });
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('quickFilterModal'));
        modal.show();
    }

    /**
     * Apply quick filter
     */
    applyQuickFilter(field, value) {
        const form = document.getElementById('filterForm');
        const fieldElement = document.getElementById(field);
        
        if (fieldElement) {
            fieldElement.value = value;
            form.submit();
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('quickFilterModal'));
        if (modal) {
            modal.hide();
        }
    }

    /**
     * Setup auto-submit for certain filters
     */
    setupAutoSubmit() {
        if (!this.options.enableAutoSubmit) return;

        this.options.autoSubmitSelects.forEach(selectId => {
            const select = document.getElementById(selectId);
            if (select) {
                select.addEventListener('change', () => {
                    document.getElementById('filterForm').submit();
                });
            }
        });
    }

    /**
     * Setup search input debounce
     */
    setupSearchDebounce() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (e.target.value.length >= 3 || e.target.value.length === 0) {
                        document.getElementById('filterForm').submit();
                    }
                }, 500);
            });
        }
    }

    /**
     * Update filter count badge
     */
    updateFilterCount() {
        const activeFilters = this.options.filterParams.filter(param => {
            const element = document.getElementById(param) || document.querySelector(`[name="${param}"]`);
            return element && element.value && element.value.trim() !== '';
        });
        
        const filterHeader = document.querySelector('.product-filter-card .card-header h5');
        if (filterHeader && activeFilters.length > 0) {
            const existingBadge = filterHeader.querySelector('.badge');
            if (existingBadge) {
                existingBadge.remove();
            }
            filterHeader.insertAdjacentHTML('beforeend', ` <span class="badge bg-warning text-dark">${activeFilters.length}</span>`);
        }
    }

    /**
     * Reset all filters
     */
    resetFilters() {
        this.options.filterParams.forEach(param => {
            const element = document.getElementById(param) || document.querySelector(`[name="${param}"]`);
            if (element) {
                element.value = '';
            }
        });
        
        document.getElementById('filterForm').submit();
    }

    /**
     * Get current filter values
     */
    getCurrentFilters() {
        const filters = {};
        this.options.filterParams.forEach(param => {
            const element = document.getElementById(param) || document.querySelector(`[name="${param}"]`);
            if (element && element.value && element.value.trim() !== '') {
                filters[param] = element.value;
            }
        });
        return filters;
    }

    /**
     * Set filter values programmatically
     */
    setFilters(filters) {
        Object.keys(filters).forEach(param => {
            const element = document.getElementById(param) || document.querySelector(`[name="${param}"]`);
            if (element) {
                element.value = filters[param];
            }
        });
        this.updateFilterCount();
    }

    /**
     * Show loading state on filter button
     */
    showLoading(show = true) {
        const submitBtn = document.querySelector('#filterForm button[type="submit"]');
        if (submitBtn) {
            if (show) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            } else {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Check if product filter exists on page
    if (document.querySelector('.product-filter-card')) {
        window.productFilter = new ProductFilter();
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProductFilter;
}
