@extends('layouts.app')

@section('title', 'Trego - Thương Mại Điện Tử')

@section('content')
<!-- Trego Homepage Layout -->

    <!-- Main Content Layout -->
    <div class="main-layout">
        <div class="container-fluid px-3">
            <div class="row g-3">
                <!-- Left Sidebar - Categories -->
                <div class="col-xl-2 col-lg-3 col-md-4">
                    @include('components.home.categories-sidebar')
                </div>

                <!-- Right Content Area -->
                <div class="col-xl-10 col-lg-9 col-md-8">
                    <!-- Hero Banner/Carousel -->
                    <div class="hero-banner-section mb-4">
                        @include('components.home.banner-carousel')
                    </div>

                    <!-- Category Icons -->
                    @include('components.home.category-icons')

                    <!-- TOP DEAL - SIÊU RẺ Section -->
                    @include('components.home.top-deal')

                   <!-- Flash Sale Section -->
                    @include('components.home.flash-sale')

                    <!-- Featured Brands Section -->
                    @include('components.home.featured-brands')
                </div>
            </div>
        </div>

        <!-- Hàng ngoại giá hot Section -->
        @include('components.home.hang-ngoai-gia-hot')

        <!-- Bạn có thể thích Section -->
        @include('components.home.ban-co-the-thich')
    </div>
</div>

<!-- Include JavaScript files -->
<script>
// Initialize all carousel sections for home page
function initAllCarousels() {
    // Initialize all carousel functions
    initTopDealCarousel();
    initFlashSaleCarousel();
    initFeaturedBrandsCarousel();
    initHangNgoaiCarousel();
    initBanCoTheThichCarousel();
}

// TOP DEAL Carousel function
function initTopDealCarousel() {
    const carousel = document.getElementById('top-deal-carousel');
    const nextButton = document.getElementById('top-deal-next');

    if (!carousel || !nextButton) return;

    const firstCard = carousel.querySelector('.top-deal-product-card');
    if (!firstCard) return;

    const cardWidth = firstCard.offsetWidth;
    const gap = 16;
    const cardWithGap = cardWidth + gap;

    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const visibleCards = Math.floor(containerWidth / cardWithGap);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWithGap);

    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            currentPosition = 0;
        } else {
            const moveCards = 3;
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }

        carousel.style.transform = `translateX(-${currentPosition}px)`;

        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);

        console.log('TOP DEAL carousel moved to position:', currentPosition);
    });

    setInterval(() => {
        nextButton.click();
    }, 8000);
}

// Flash Sale Carousel function
function initFlashSaleCarousel() {
    const carousel = document.getElementById('flash-sale-carousel');
    const nextButton = document.getElementById('flash-sale-next');

    if (!carousel || !nextButton) return;

    const firstCard = carousel.querySelector('.flash-sale-product-card');
    if (!firstCard) return;

    const cardWidth = firstCard.offsetWidth;
    const gap = 16;
    const cardWithGap = cardWidth + gap;

    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const visibleCards = Math.floor(containerWidth / cardWithGap);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWithGap);

    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            currentPosition = 0;
        } else {
            const moveCards = 3;
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }

        carousel.style.transform = `translateX(-${currentPosition}px)`;

        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);

        console.log('Flash Sale carousel moved to position:', currentPosition);
    });

    setInterval(() => {
        nextButton.click();
    }, 8000);
}

// Featured Brands Carousel function
function initFeaturedBrandsCarousel() {
    const carousel = document.querySelector('.brands-carousel');
    const nextButton = document.getElementById('brands-next');
    
    if (!carousel || !nextButton) return;

    const firstCard = carousel.querySelector('.brand-card');
    if (!firstCard) return;
    
    const cardWidth = firstCard.offsetWidth;
    const gap = 16;
    const cardWithGap = cardWidth + gap;
    
    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const visibleCards = Math.floor(containerWidth / cardWithGap);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWithGap);
    
    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            currentPosition = 0;
        } else {
            const moveCards = 2;
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }
        
        carousel.style.transform = `translateX(-${currentPosition}px)`;
        
        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);

        console.log('Featured Brands carousel moved to position:', currentPosition);
    });
    
    setInterval(() => {
        nextButton.click();
    }, 10000);
}

// Hàng ngoại giá hot Carousel function
function initHangNgoaiCarousel() {
    const carousel = document.getElementById('hang-ngoai-carousel');
    const nextButton = document.getElementById('hang-ngoai-next');

    if (!carousel || !nextButton) return;

    const firstCard = carousel.querySelector('.hang-ngoai-product-card');
    if (!firstCard) return;

    const cardWidth = firstCard.offsetWidth;
    const gap = 16;
    const cardWithGap = cardWidth + gap;

    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const visibleCards = Math.floor(containerWidth / cardWithGap);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWithGap);

    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            currentPosition = 0;
        } else {
            const moveCards = 3;
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }

        carousel.style.transform = `translateX(-${currentPosition}px)`;

        this.style.transform = 'translateY(-50%) scale(0.9)';
            setTimeout(() => {
            this.style.transform = 'translateY(-50%) scale(1)';
            }, 150);
            
        console.log('Hàng ngoại carousel moved to position:', currentPosition);
    });

    setInterval(() => {
        nextButton.click();
    }, 8000);
}

// Bạn có thể thích Carousel function
function initBanCoTheThichCarousel() {
    const carousel = document.getElementById('ban-co-the-thich-carousel');
    const nextButton = document.getElementById('ban-co-the-thich-next');
    
    if (!carousel || !nextButton) return;

    const firstCard = carousel.querySelector('.ban-co-the-thich-product-card');
    if (!firstCard) return;

    const cardWidth = firstCard.offsetWidth;
    const gap = 16;
    const cardWithGap = cardWidth + gap;

    let currentPosition = 0;
    const containerWidth = carousel.parentElement.offsetWidth;
    const calculatedVisibleCards = Math.floor(containerWidth / cardWithGap);
    const maxVisibleCards = 6; // Giới hạn tối đa 6 sản phẩm hiển thị
    const visibleCards = Math.min(calculatedVisibleCards, maxVisibleCards);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWithGap);

    nextButton.addEventListener('click', function() {
        if (currentPosition >= maxScroll) {
            currentPosition = 0;
        } else {
            const moveCards = 3;
            currentPosition += cardWithGap * moveCards;
            if (currentPosition > maxScroll) {
                currentPosition = maxScroll;
            }
        }

        carousel.style.transform = `translateX(-${currentPosition}px)`;

            this.style.transform = 'translateY(-50%) scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'translateY(-50%) scale(1)';
            }, 150);
            
        console.log('Bạn có thể thích carousel moved to position:', currentPosition);
    });

    setInterval(() => {
        nextButton.click();
    }, 8000);
}

// Add to cart functionality
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
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
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

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initAllCarousels();
});
</script>
@endsection