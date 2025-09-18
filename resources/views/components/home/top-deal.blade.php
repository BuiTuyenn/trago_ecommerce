<!-- TOP DEAL - SIÊU RẺ Section Component -->
<div class="deals-section">
    <div class="section-header d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title mb-0">
            <i class="fas fa-fire text-warning me-2"></i>
            <span class="text-primary">TOP DEAL</span> - <span class="text-danger">SIÊU RẺ</span>
        </h4>
        <a href="{{ route('products.index') }}" class="btn btn-link text-primary p-0">Xem tất cả</a>
    </div>
    
    <div class="top-deal-container position-relative">
        <div class="top-deal-carousel-container">
            <div class="top-deal-carousel" id="top-deal-carousel">
                <!-- Product 1 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/e8f5e8/2e7d32?text=iPhone+15" alt="iPhone 15" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-15%</div>
                        <div class="hot-badge">HOT</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">iPhone 15 Pro Max 256GB</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">25.990.000₫</span>
                            <span class="original-price">30.990.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(1)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/e0f2f7/00838f?text=MacBook+Air" alt="MacBook Air" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-20%</div>
                        <div class="bestseller-badge">BESTSELLER</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">MacBook Air M3 13inch 256GB</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-muted"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">23.990.000₫</span>
                            <span class="original-price">29.990.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(2)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/fce4ec/c2185b?text=Samsung+S24" alt="Samsung S24" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-25%</div>
                        <div class="new-badge">NEW</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">Samsung Galaxy S24 Ultra 512GB</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">22.490.000₫</span>
                            <span class="original-price">29.990.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(3)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/e3f2fd/1976d2?text=AirPods+Pro" alt="AirPods Pro" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-30%</div>
                        <div class="limited-badge">LIMITED</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">Apple AirPods Pro 2nd Gen</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">4.990.000₫</span>
                            <span class="original-price">7.190.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(4)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/f3e5f5/7b1fa2?text=iPad+Air" alt="iPad Air" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-18%</div>
                        <div class="exclusive-badge">EXCLUSIVE</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">iPad Air M2 11inch 128GB WiFi</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-muted"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">14.990.000₫</span>
                            <span class="original-price">18.290.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(5)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/ffebee/d32f2f?text=Gaming+Laptop" alt="Gaming Laptop" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-22%</div>
                        <div class="gaming-badge">GAMING</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">ASUS ROG Strix G15 RTX 4060</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">19.990.000₫</span>
                            <span class="original-price">25.690.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(6)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/fff8e1/f9a825?text=Xiaomi+14" alt="Xiaomi 14" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-28%</div>
                        <div class="flash-badge">FLASH</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">Xiaomi 14 Ultra 512GB</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-muted"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">21.990.000₫</span>
                            <span class="original-price">30.590.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(7)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/e1f5fe/0277bd?text=Surface+Pro" alt="Surface Pro" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-35%</div>
                        <div class="premium-badge">PREMIUM</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">Microsoft Surface Pro 9 i7 512GB</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">32.990.000₫</span>
                            <span class="original-price">50.790.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(8)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>

                <!-- Product 9 -->
                <div class="top-deal-product-card">
                    <div class="product-image-container position-relative">
                        <img src="https://via.placeholder.com/200x200/f3e5f5/7b1fa2?text=Apple+Watch" alt="Apple Watch" class="top-deal-product-image">
                        <div class="discount-badge-top-deal">-12%</div>
                        <div class="smartwatch-badge">SMARTWATCH</div>
                    </div>
                    <div class="top-deal-product-details">
                        <h6 class="top-deal-product-title">Apple Watch Series 9 GPS 45mm</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-muted"></i>
                        </div>
                        <div class="price-container">
                            <span class="current-price">10.790.000₫</span>
                            <span class="original-price">12.290.000₫</span>
                        </div>
                        <button class="btn btn-primary btn-sm add-to-cart-btn w-100" onclick="addToCart(9)">
                            <i class="fas fa-shopping-cart me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Next Button -->
        <button class="section-next-btn top-deal-next-btn" id="top-deal-next">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
