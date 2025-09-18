// ============================================
// STICKY SIDEBAR ENHANCEMENT
// ============================================

// Initialize sticky sidebar functionality
function initStickySidebar() {
    const sidebar = document.querySelector('.categories-sidebar');
    const mainContent = document.querySelector('.main-content-column');
    const backToTopBtn = createBackToTopButton();
    const scrollProgress = createScrollProgress();
    
    if (!sidebar || !mainContent) return;
    
    // Handle scroll events
    let ticking = false;
    
    function updateScrollElements() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollProgress = (scrollTop / scrollHeight) * 100;
        
        // Update scroll progress bar
        updateScrollProgressBar(scrollProgress);
        
        // Show/hide back to top button
        updateBackToTopButton(scrollTop);
        
        // Update sidebar shadow based on scroll
        updateSidebarShadow(scrollTop);
        
        ticking = false;
    }
    
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(updateScrollElements);
            ticking = true;
        }
    }
    
    // Create back to top button
    function createBackToTopButton() {
        const button = document.createElement('button');
        button.className = 'back-to-top';
        button.innerHTML = '<i class="fas fa-arrow-up"></i>';
        button.setAttribute('aria-label', 'Về đầu trang');
        button.setAttribute('title', 'Về đầu trang');
        
        button.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Focus on main content for accessibility
            const mainHeading = document.querySelector('h1, h2, .main-content-column');
            if (mainHeading) {
                mainHeading.focus();
            }
        });
        
        document.body.appendChild(button);
        return button;
    }
    
    // Create scroll progress indicator
    function createScrollProgress() {
        const indicator = document.createElement('div');
        indicator.className = 'main-content-scroll-indicator';
        indicator.innerHTML = '<div class="main-content-scroll-progress"></div>';
        indicator.setAttribute('role', 'progressbar');
        indicator.setAttribute('aria-label', 'Tiến độ cuộn trang');
        
        document.body.appendChild(indicator);
        return indicator;
    }
    
    // Update scroll progress bar
    function updateScrollProgressBar(progress) {
        const progressBar = document.querySelector('.main-content-scroll-progress');
        if (progressBar) {
            progressBar.style.width = `${Math.min(100, Math.max(0, progress))}%`;
            progressBar.parentElement.setAttribute('aria-valuenow', Math.round(progress));
        }
    }
    
    // Update back to top button visibility
    function updateBackToTopButton(scrollTop) {
        const threshold = 300; // Show after scrolling 300px
        
        if (scrollTop > threshold) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    }
    
    // Update sidebar shadow based on scroll
    function updateSidebarShadow(scrollTop) {
        const maxShadow = 0.15;
        const shadowIntensity = Math.min(maxShadow, scrollTop / 1000);
        
        sidebar.style.boxShadow = `0 2px 8px rgba(0, 0, 0, 0.05), 0 8px 32px rgba(0, 0, 0, ${shadowIntensity})`;
    }
    
    // Handle keyboard navigation for sidebar
    function initSidebarKeyboardNav() {
        sidebar.addEventListener('keydown', function(e) {
            // Allow Escape key to blur focus from sidebar
            if (e.key === 'Escape') {
                const focusedElement = document.activeElement;
                if (sidebar.contains(focusedElement)) {
                    focusedElement.blur();
                    // Focus on main content
                    const mainContent = document.querySelector('.main-content-column');
                    if (mainContent) {
                        mainContent.setAttribute('tabindex', '-1');
                        mainContent.focus();
                        mainContent.removeAttribute('tabindex');
                    }
                }
            }
        });
    }
    
    // Handle intersection observer for performance
    function initIntersectionObserver() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(
                function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Element is visible, enable animations
                            entry.target.style.willChange = 'transform, opacity';
                        } else {
                            // Element is not visible, disable animations for performance
                            entry.target.style.willChange = 'auto';
                        }
                    });
                },
                { 
                    rootMargin: '50px 0px',
                    threshold: 0.1
                }
            );
            
            // Observe content sections
            const contentSections = document.querySelectorAll('.content-section');
            contentSections.forEach(section => observer.observe(section));
        }
    }
    
    // Handle resize events
    function onResize() {
        // Recalculate sticky positioning on resize
        const viewportHeight = window.innerHeight;
        const headerHeight = 120; // Adjust based on your header
        
        sidebar.style.maxHeight = `${viewportHeight - headerHeight}px`;
        
        // Update scroll progress
        updateScrollElements();
    }
    
    // Initialize all functionality
    function init() {
        // Add scroll listener with passive flag for performance
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onResize, { passive: true });
        
        // Initialize keyboard navigation
        initSidebarKeyboardNav();
        
        // Initialize intersection observer
        initIntersectionObserver();
        
        // Initial setup
        onResize();
        updateScrollElements();
        
        // Add smooth scroll polyfill for older browsers
        if (!('scrollBehavior' in document.documentElement.style)) {
            loadSmoothScrollPolyfill();
        }
    }
    
    // Load smooth scroll polyfill if needed
    function loadSmoothScrollPolyfill() {
        // Simple polyfill for smooth scrolling
        const originalScrollTo = window.scrollTo;
        window.scrollTo = function(options) {
            if (typeof options === 'object' && options.behavior === 'smooth') {
                smoothScrollTo(options.top || 0);
            } else {
                originalScrollTo.apply(this, arguments);
            }
        };
        
        function smoothScrollTo(targetY) {
            const startY = window.pageYOffset;
            const distance = targetY - startY;
            const duration = 500;
            let startTime = null;
            
            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                
                // Easing function (ease-out)
                const ease = 1 - Math.pow(1 - progress, 3);
                
                window.scrollTo(0, startY + distance * ease);
                
                if (progress < 1) {
                    requestAnimationFrame(animation);
                }
            }
            
            requestAnimationFrame(animation);
        }
    }
    
    // Initialize everything
    init();
    
    // Return public API
    return {
        updateScrollElements,
        scrollToTop: () => window.scrollTo({ top: 0, behavior: 'smooth' }),
        scrollToSection: (selector) => {
            const element = document.querySelector(selector);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
    };
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.stickySidebarAPI = initStickySidebar();
});

// Export for external use
window.StickySidebarFunctions = {
    initStickySidebar
};
