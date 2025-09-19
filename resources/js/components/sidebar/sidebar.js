/**
 * Sidebar Category Toggle Functionality
 */

// Toggle category expand/collapse
function toggleCategory(element) {
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
}

// Initialize sidebar when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Make sure all initially expanded categories are properly set
    const expandedCategories = document.querySelectorAll('.category-item.expanded');
    expandedCategories.forEach(function(categoryItem) {
        const subcategoryList = categoryItem.querySelector('.subcategory-list');
        const icon = categoryItem.querySelector('.category-link i');
        if (subcategoryList) {
            subcategoryList.style.display = 'block';
        }
        if (icon) {
            icon.className = 'fas fa-chevron-up';
        }
    });
    
    // Make sure all collapsed categories are properly set
    const collapsedCategories = document.querySelectorAll('.category-item.expandable:not(.expanded)');
    collapsedCategories.forEach(function(categoryItem) {
        const subcategoryList = categoryItem.querySelector('.subcategory-list');
        const icon = categoryItem.querySelector('.category-link i');
        if (subcategoryList) {
            subcategoryList.style.display = 'none';
        }
        if (icon) {
            icon.className = 'fas fa-chevron-down';
        }
    });
    
    // Smart sidebar behavior for static positioning
    initSmartSidebarBehavior();
});

// Basic sidebar behavior for static positioning
function initSmartSidebarBehavior() {
    const sidebar = document.querySelector('.bookstore-sidebar');
    
    if (!sidebar) return;
    
    // Remove any inline max-height styles to allow full expansion
    sidebar.style.maxHeight = 'none';
    sidebar.style.height = 'auto';
    sidebar.style.position = 'relative';
    sidebar.style.top = 'auto';
    sidebar.style.zIndex = '10';
    
    // Simple function to ensure sidebar shows all content with fixed width
    function ensureFullDisplay() {
        sidebar.style.maxHeight = 'none';
        sidebar.style.height = 'auto';
        sidebar.style.overflow = 'visible';
        sidebar.style.width = '100%';
        sidebar.style.minWidth = '250px';
        sidebar.style.flexShrink = '0';
        sidebar.style.position = 'relative';
        sidebar.style.top = 'auto';
        sidebar.style.zIndex = '10';
    }
    
    // Listen to category toggle events to ensure full display
    document.addEventListener('click', function(e) {
        if (e.target.closest('.category-link')) {
            setTimeout(ensureFullDisplay, 50); // Wait for animation to start
        }
    });
    
    // Initial call
    ensureFullDisplay();
}

// Export function for global access
window.toggleCategory = toggleCategory;
