// ============================================
// CATEGORIES SIDEBAR SCROLL ENHANCEMENT
// ============================================

// Initialize categories sidebar scroll functionality
function initCategoriesScroll() {
    const categoriesMenu = document.querySelector('.categories-menu');
    const categoriesSidebar = document.querySelector('.categories-sidebar');
    
    if (!categoriesMenu || !categoriesSidebar) return;
    
    // Add mouse wheel support for better scrolling
    categoriesMenu.addEventListener('wheel', function(e) {
        // Allow normal wheel scrolling
        e.stopPropagation();
    });
    
    // Add keyboard navigation support
    categoriesMenu.addEventListener('keydown', function(e) {
        const focusedLink = document.activeElement;
        const allLinks = Array.from(this.querySelectorAll('a'));
        const currentIndex = allLinks.indexOf(focusedLink);
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                const nextIndex = Math.min(currentIndex + 1, allLinks.length - 1);
                allLinks[nextIndex]?.focus();
                scrollToFocusedItem(allLinks[nextIndex]);
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                const prevIndex = Math.max(currentIndex - 1, 0);
                allLinks[prevIndex]?.focus();
                scrollToFocusedItem(allLinks[prevIndex]);
                break;
                
            case 'Home':
                e.preventDefault();
                allLinks[0]?.focus();
                categoriesMenu.scrollTop = 0;
                break;
                
            case 'End':
                e.preventDefault();
                allLinks[allLinks.length - 1]?.focus();
                categoriesMenu.scrollTop = categoriesMenu.scrollHeight;
                break;
        }
    });
    
    // Smooth scroll to focused item
    function scrollToFocusedItem(item) {
        if (!item) return;
        
        const menuRect = categoriesMenu.getBoundingClientRect();
        const itemRect = item.getBoundingClientRect();
        
        if (itemRect.top < menuRect.top) {
            // Item is above visible area
            categoriesMenu.scrollTop -= (menuRect.top - itemRect.top + 10);
        } else if (itemRect.bottom > menuRect.bottom) {
            // Item is below visible area
            categoriesMenu.scrollTop += (itemRect.bottom - menuRect.bottom + 10);
        }
    }
    
    // Add scroll indicators
    function updateScrollIndicators() {
        const isScrollable = categoriesMenu.scrollHeight > categoriesMenu.clientHeight;
        const isAtTop = categoriesMenu.scrollTop === 0;
        const isAtBottom = categoriesMenu.scrollTop + categoriesMenu.clientHeight >= categoriesMenu.scrollHeight - 1;
        
        categoriesSidebar.classList.toggle('scrollable', isScrollable);
        categoriesSidebar.classList.toggle('scroll-top', isScrollable && !isAtTop);
        categoriesSidebar.classList.toggle('scroll-bottom', isScrollable && !isAtBottom);
    }
    
    // Update indicators on scroll
    categoriesMenu.addEventListener('scroll', updateScrollIndicators);
    
    // Initial check
    updateScrollIndicators();
    
    // Update on resize
    window.addEventListener('resize', updateScrollIndicators);
    
    // Add smooth scroll behavior for category links
    const categoryLinks = categoriesMenu.querySelectorAll('a');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add ripple effect
            createRippleEffect(this, e);
        });
    });
    
    // Create ripple effect on click
    function createRippleEffect(element, event) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(37, 99, 235, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        
        // Add ripple animation CSS if not exists
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
                .category-list a {
                    position: relative;
                    overflow: hidden;
                }
            `;
            document.head.appendChild(style);
        }
        
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initCategoriesScroll();
});

// Export for external use
window.CategoriesScrollFunctions = {
    initCategoriesScroll
};
