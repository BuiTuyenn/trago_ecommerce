<!-- Trego Footer (Tiki-style) -->
<footer class="trego-footer bg-light">
    <div class="container">
        <div class="row py-5">
            <!-- Hỗ trợ khách hàng -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Hỗ trợ khách hàng</h6>
                <ul class="footer-links">
                    <li><span class="hotline">Hotline: <strong>1900-6035</strong></span></li>
                    <li><small class="text-muted">(1000 đ/phút, 8-21h kể cả T7, CN)</small></li>
                    <li><a href="#">Các câu hỏi thường gặp</a></li>
                    <li><a href="#">Gửi yêu cầu hỗ trợ</a></li>
                    <li><a href="#">Hướng dẫn đặt hàng</a></li>
                    <li><a href="#">Phương thức vận chuyển</a></li>
                    <li><a href="#">Chính sách kiểm hàng</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Hướng dẫn trả góp</a></li>
                </ul>
                
                <div class="mt-3">
                    <p class="mb-1"><strong>Email hỗ trợ:</strong></p>
                    <p class="mb-1"><a href="mailto:hotro@trego.vn" class="text-primary">hotro@trego.vn</a></p>
                    <p class="mb-0"><a href="mailto:security@trego.vn" class="text-primary">security@trego.vn</a></p>
                </div>
            </div>

            <!-- Về Trego -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Về Trego</h6>
                <ul class="footer-links">
                    <li><a href="#">Giới thiệu Trego</a></li>
                    <li><a href="#">Trego Blog</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Chính sách bảo mật thanh toán</a></li>
                    <li><a href="#">Chính sách bảo mật thông tin</a></li>
                    <li><a href="#">Chính sách giải quyết khiếu nại</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Giới thiệu Trego Xu</a></li>
                    <li><a href="#">Tiếp thị liên kết cùng Trego</a></li>
                    <li><a href="#">Bán hàng doanh nghiệp</a></li>
                </ul>
                
                <div class="mt-4">
                    <h6 class="footer-title">Chứng nhận bởi</h6>
                    <div class="certificates">
                        <img src="{{ asset('images/footer/certificates/bo-cong-thuong.svg') }}" alt="Bộ Công Thương" class="cert-img">
                        <img src="{{ asset('images/footer/certificates/dmca.svg') }}" alt="DMCA" class="cert-img">
                    </div>
                </div>
            </div>

            <!-- Phương thức thanh toán & Giao hàng -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Phương thức thanh toán</h6>
                <div class="payment-methods mb-4">
                    <div class="payment-row">
                        <img src="{{ asset('images/footer/payments/trego.svg') }}" alt="Trego" class="payment-img">
                        <img src="{{ asset('images/footer/payments/visa.svg') }}" alt="Visa" class="payment-img">
                        <img src="{{ asset('images/footer/payments/mastercard.svg') }}" alt="Mastercard" class="payment-img">
                        <img src="{{ asset('images/footer/payments/jcb.svg') }}" alt="JCB" class="payment-img">
                    </div>
                    <div class="payment-row">
                        <img src="{{ asset('images/footer/payments/atm.svg') }}" alt="ATM" class="payment-img">
                        <img src="{{ asset('images/footer/payments/momo.svg') }}" alt="Momo" class="payment-img">
                        <img src="{{ asset('images/footer/payments/zalopay.svg') }}" alt="ZaloPay" class="payment-img">
                        <img src="{{ asset('images/footer/payments/vnpay.svg') }}" alt="VNPay" class="payment-img">
                    </div>
                </div>

                <h6 class="footer-title">Dịch vụ giao hàng</h6>
                <div class="delivery-service">
                    <img src="{{ asset('images/footer/delivery/tregonow.svg') }}" alt="TregoNOW" class="delivery-img">
                </div>
                
                <div class="mt-3">
                    <ul class="footer-links">
                        <li><a href="#">Quy chế hoạt động Sàn GĐTMĐT</a></li>
                        <li><a href="#">Bán hàng cùng Trego</a></li>
                    </ul>
                </div>
            </div>

            <!-- Kết nối & Tải ứng dụng -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Kết nối với chúng tôi</h6>
                <div class="social-links mb-4">
                    <a href="#" class="social-link facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link zalo"><i class="fab fa-telegram"></i></a>
                </div>

                <h6 class="footer-title">Tải ứng dụng trên điện thoại</h6>
                <div class="app-download mb-4">
                    <div class="qr-code">
                        <img src="{{ asset('images/footer/apps/qr-code.svg') }}" alt="QR Code" class="qr-img">
                    </div>
                    <div class="download-links">
                        <a href="#" class="download-btn">
                            <img src="{{ asset('images/footer/apps/app-store.svg') }}" alt="App Store" class="store-img">
                        </a>
                        <a href="#" class="download-btn">
                            <img src="{{ asset('images/footer/apps/google-play.svg') }}" alt="Google Play" class="store-img">
                        </a>
                    </div>
                </div>
                
                <!-- Newsletter Signup -->
                <div class="newsletter-signup">
                    <h6 class="footer-title">Đăng ký nhận tin khuyến mại</h6>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" placeholder="Nhập email của bạn">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom bg-white">
        <div class="container">
            <div class="py-4">
                <div class="company-info">
                    <h6 class="mb-3">Công ty TNHH TREGO</h6>
                    <p class="mb-1">Chí minh, Hưng yên, Việt Nam</p>
                    <p class="mb-1">Giấy chứng nhận đăng ký doanh nghiệp số 0123456789 do Sở Kế Hoạch và Đầu Tư Thành phố Hà Nội cấp lần đầu vào ngày 06/01/2025.</p>
                    <p class="mb-0">Hotline: <a href="tel:19006035" class="text-primary">1900 6035</a></p>
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
