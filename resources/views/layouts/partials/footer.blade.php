<!-- Footer Component -->
<footer class="main-footer">
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <!-- Company Information -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="footer-heading">{{ config('app.name', 'E-Commerce') }}</h5>
                    <p class="company-description">
                        Hệ thống thương mại điện tử hiện đại với trải nghiệm mua sắm tuyệt vời. 
                        Chúng tôi cung cấp hàng ngàn sản phẩm chất lượng cao với giá cả hợp lý 
                        và dịch vụ khách hàng tận tâm.
                    </p>
                    
                    <!-- Social Media Links -->
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Liên kết nhanh</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                        <li><a href="{{ route('categories.index') }}">Danh mục</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>

                <!-- Customer Support -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Hỗ trợ khách hàng</h5>
                    <ul class="footer-links">
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Phương thức thanh toán</a></li>
                        <li><a href="#">Vận chuyển & Giao hàng</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Thông tin liên hệ</h5>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Đường ABC, Quận 1, TP.HCM, Việt Nam</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+84 123 456 789</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@ecommerce.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>T2-T7: 8:00 - 22:00<br>CN: 9:00 - 21:00</span>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="newsletter-form">
                        <h6 class="text-white mb-2">Đăng ký nhận tin</h6>
                        <form action="#" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Nhập email của bạn..." required>
                                <button class="btn" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                        <small class="text-muted d-block mt-2">
                            Nhận thông tin khuyến mại và sản phẩm mới
                        </small>
                    </div>
                </div>
            </div>

            <!-- Featured Categories -->
            <div class="row mt-4 pt-4" style="border-top: 1px solid rgba(75, 85, 99, 0.3);">
                <div class="col-12">
                    <h6 class="footer-heading text-center mb-3">Danh mục nổi bật</h6>
                    <div class="row">
                        @php
                            $footerCategories = \App\Models\Category::active()->parent()->take(6)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <div class="col-lg-2 col-md-4 col-6 mb-2">
                                <a href="{{ route('products.category', $category->slug) }}" class="text-decoration-none">
                                    <small class="text-muted hover-link">{{ $category->name }}</small>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'E-Commerce') }}. Tất cả quyền được bảo lưu.</p>
                </div>
                
                <div class="footer-brand">
                    <span>Được phát triển với</span>
                    <i class="fas fa-heart"></i>
                    <span>bởi Laravel & Bootstrap</span>
                </div>
                
                <!-- Payment Methods -->
                <div class="payment-methods">
                    <small class="text-muted me-3">Phương thức thanh toán:</small>
                    <div class="payment-method" title="Visa">
                        <i class="fab fa-cc-visa"></i>
                    </div>
                    <div class="payment-method" title="Mastercard">
                        <i class="fab fa-cc-mastercard"></i>
                    </div>
                    <div class="payment-method" title="PayPal">
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                    <div class="payment-method" title="VNPay">
                        <span style="font-size: 0.7rem; font-weight: bold; color: #1976d2;">VNP</span>
                    </div>
                    <div class="payment-method" title="MoMo">
                        <span style="font-size: 0.7rem; font-weight: bold; color: #d82d8b;">MoMo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Footer JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top button functionality
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });
    
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Newsletter form handling
    const newsletterForm = document.querySelector('.newsletter-form form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // TODO: Implement newsletter subscription
            alert('Cảm ơn bạn đã đăng ký nhận tin! Email: ' + email);
            this.reset();
        });
    }
    
    // Social links tracking (placeholder)
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').classList[1].split('-')[2];
            console.log('Social link clicked:', platform);
            // TODO: Implement social media links
        });
    });
    
    // Contact info click handlers
    document.querySelectorAll('.contact-item').forEach(item => {
        const icon = item.querySelector('i');
        const text = item.querySelector('span').textContent;
        
        item.addEventListener('click', function() {
            if (icon.classList.contains('fa-phone')) {
                window.location.href = 'tel:' + text.replace(/\s/g, '');
            } else if (icon.classList.contains('fa-envelope')) {
                window.location.href = 'mailto:' + text;
            } else if (icon.classList.contains('fa-map-marker-alt')) {
                // TODO: Open Google Maps
                console.log('Opening map for:', text);
            }
        });
    });
});
</script>

<!-- Back to Top Button Styles -->
<style>
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
}

.hover-link {
    transition: all 0.3s ease;
}

.hover-link:hover {
    color: #2563eb !important;
    transform: translateX(3px);
}

@media (max-width: 768px) {
    .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
        font-size: 1rem;
    }
}
</style>
