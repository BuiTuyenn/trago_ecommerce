// ============================================
// HOME PAGE JAVASCRIPT FUNCTIONS
// ============================================

// Flash Sale Countdown Timer
function startFlashSaleCountdown() {
    // Set flash sale end time (24 hours from now for demo)
    const endTime = new Date().getTime() + (24 * 60 * 60 * 1000);
    
    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = endTime - now;
        
        if (timeLeft > 0) {
            const hours = Math.floor(timeLeft / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            
            // Update display
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');
            
            if (hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
            if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
            if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
        } else {
            // Flash sale ended
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');
            
            if (hoursEl) hoursEl.textContent = '00';
            if (minutesEl) minutesEl.textContent = '00';
            if (secondsEl) secondsEl.textContent = '00';
        }
    }
    
    // Update every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Flash Sale Grid Toggle
function initFlashSaleGridToggle() {
    const gridToggleButtons = document.querySelectorAll('input[name="flash-view"]');
    const flashContainer = document.getElementById('flash-products-container');
    
    if (!flashContainer) return;
    
    gridToggleButtons.forEach(button => {
        button.addEventListener('change', function() {
            if (this.checked) {
                // Remove all existing grid classes with animation
                flashContainer.style.opacity = '0.7';
                flashContainer.style.transform = 'scale(0.98)';
                
                setTimeout(() => {
                    // Remove all existing grid classes
                    flashContainer.classList.remove('flash-grid-2', 'flash-grid-3', 'flash-grid-6');
                    
                    // Add new grid class based on selection
                    const gridValue = this.value;
                    flashContainer.classList.add(`flash-grid-${gridValue}`);
                    
                    // Animate back
                    flashContainer.style.opacity = '1';
                    flashContainer.style.transform = 'scale(1)';
                    
                    // Store user preference
                    localStorage.setItem('flash-sale-grid-view', gridValue);
                    
                    console.log(`Flash Sale grid changed to: ${gridValue} columns`);
                }, 150);
            }
        });
    });
    
    // Add CSS transitions
    flashContainer.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    
    // Load saved preference
    const savedView = localStorage.getItem('flash-sale-grid-view');
    if (savedView) {
        const savedButton = document.getElementById(`flash-grid-${savedView}`);
        if (savedButton) {
            savedButton.checked = true;
            flashContainer.classList.add(`flash-grid-${savedView}`);
        }
    } else {
        // Default to 6-column view (like TOP DEAL)
        flashContainer.classList.add('flash-grid-6');
        const defaultButton = document.getElementById('flash-grid-6');
        if (defaultButton) {
            defaultButton.checked = true;
        }
    }
}

// Featured Brands Carousel
function initBrandsCarousel() {
    const carousel = document.querySelector('.brands-carousel');
    const nextButton = document.getElementById('brands-next');
    
    if (!carousel || !nextButton) return;
    
    // Get actual card width and gap dynamically
    const firstCard = carousel.querySelector('.brand-card');
    if (!firstCard) return;
    
    const cardStyle = window.getComputedStyle(firstCard);
    const cardWidth = firstCard.offsetWidth;
    const gap = 16; // 1rem = 16px
    const cardWithGap = cardWidth + gap;
    
    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const visibleCards = Math.floor(containerWidth / cardWithGap);
    const maxScroll = Math.max(0, (carousel.children.length - visibleCards) * cardWithGap);
    
    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            // Reset to beginning
            currentPosition = 0;
        } else {
            // Move to next set (move 2 cards or whatever fits)
            const moveCards = Math.min(2, Math.ceil(visibleCards / 2));
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }
        
        carousel.style.transform = `translateX(-${currentPosition}px)`;
        
        // Add visual feedback
        nextButton.style.transform = 'scale(0.9)';
        setTimeout(() => {
            nextButton.style.transform = 'scale(1)';
        }, 150);
    });
    
    // Auto-scroll every 5 seconds
    setInterval(() => {
        nextButton.click();
    }, 5000);
}

// Initialize all next buttons
function initAllNextButtons() {
    // TOP DEAL next button
    const topDealNext = document.getElementById('top-deal-next');
    if (topDealNext) {
        topDealNext.addEventListener('click', function() {
            // Add animation effect
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Here you can add logic to navigate to next set of products
            console.log('TOP DEAL next clicked');
        });
    }
    
    // Flash Sale next button
    const flashSaleNext = document.getElementById('flash-sale-next');
    if (flashSaleNext) {
        flashSaleNext.addEventListener('click', function() {
            // Add animation effect
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Here you can add logic to navigate to next set of flash sale products
            console.log('Flash Sale next clicked');
        });
    }
    
    // Hàng ngoại giá hot next button
    const hangNgoaiNext = document.getElementById('hang-ngoai-next');
    if (hangNgoaiNext) {
        hangNgoaiNext.addEventListener('click', function() {
            // Add animation effect
            this.style.transform = 'translateY(-50%) scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'translateY(-50%) scale(1)';
            }, 150);
            
            // Here you can add logic to navigate to next set of hang ngoai products
            console.log('Hàng ngoại giá hot next clicked');
        });
    }
}

// Add to cart function
function addToCart(productId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count if exists
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.cart_count) {
                cartCount.textContent = data.cart_count;
                cartCount.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    cartCount.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            }
            
            // Show success message
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại!');
    });
}

// Initialize all functions when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    startFlashSaleCountdown();
    initFlashSaleGridToggle();
    initBrandsCarousel();
    initAllNextButtons();
});

// Export functions for external use
window.HomePageFunctions = {
    startFlashSaleCountdown,
    initFlashSaleGridToggle,
    initBrandsCarousel,
    initAllNextButtons,
    addToCart
};
