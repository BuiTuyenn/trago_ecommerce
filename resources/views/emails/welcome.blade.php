<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với Trego E-Commerce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-msg {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid #4caf50;
            margin: 25px 0;
        }
        .features {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .feature-icon {
            background: #667eea;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🛒 TREGO</div>
            <h1>Chào mừng bạn đến với Trego!</h1>
            <p>Nơi mua sắm trực tuyến tốt nhất</p>
        </div>
        
        <div class="content">
            <h2>Xin chào {{ $userName }}! 👋</h2>
            
            <div class="welcome-msg">
                <h3>🎉 Chúc mừng bạn đã đăng ký thành công!</h3>
                <p>Cảm ơn bạn đã tham gia cộng đồng Trego E-Commerce. Chúng tôi rất vui mừng được chào đón bạn!</p>
            </div>
            
            <p>Tài khoản của bạn đã được tạo với email: <strong>{{ $userEmail }}</strong></p>
            
            <div class="features">
                <h3>🚀 Những gì bạn có thể làm với Trego:</h3>
                
                <div class="feature-item">
                    <div class="feature-icon">🛍️</div>
                    <div>
                        <strong>Mua sắm dễ dàng</strong><br>
                        Hàng ngàn sản phẩm chất lượng với giá tốt nhất
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">🚚</div>
                    <div>
                        <strong>Giao hàng nhanh chóng</strong><br>
                        Freeship toàn quốc, giao hàng trong 2-24h
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">💎</div>
                    <div>
                        <strong>Chất lượng đảm bảo</strong><br>
                        100% hàng chính hãng, hoàn tiền nếu không hài lòng
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">🎁</div>
                    <div>
                        <strong>Ưu đãi độc quyền</strong><br>
                        Nhận thông báo về flash sale và khuyến mãi đặc biệt
                    </div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="cta-button">
                    🛒 Bắt đầu mua sắm ngay
                </a>
                <br><br>
                <a href="{{ route('products.index') }}" class="cta-button" style="background: #28a745;">
                    🎯 Khám phá sản phẩm
                </a>
            </div>
            
            <div style="background: #fff3cd; padding: 20px; border-radius: 10px; border-left: 5px solid #ffc107; margin: 25px 0;">
                <h4>📧 Quan trọng: Xác thực email</h4>
                <p>Để đảm bảo an toàn tài khoản, vui lòng kiểm tra email và nhấp vào liên kết xác thực. Nếu bạn không thấy email, hãy kiểm tra thư mục spam.</p>
            </div>
            
            <h4>🆘 Cần hỗ trợ?</h4>
            <p>Đội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng giúp đỡ:</p>
            <ul>
                <li>📞 Hotline: 1900-1234</li>
                <li>📧 Email: support@trego.com</li>
                <li>💬 Live chat trên website</li>
                <li>🕒 Thời gian hỗ trợ: 8:00 - 22:00 hàng ngày</li>
            </ul>
        </div>
        
        <div class="footer">
            <h3>Kết nối với chúng tôi</h3>
            <div class="social-links">
                <a href="#">📘 Facebook</a>
                <a href="#">📷 Instagram</a>
                <a href="#">🐦 Twitter</a>
                <a href="#">📺 YouTube</a>
            </div>
            <p>© {{ date('Y') }} Trego E-Commerce. Tất cả quyền được bảo lưu.</p>
            <p style="font-size: 12px; opacity: 0.8;">
                Bạn nhận được email này vì đã đăng ký tài khoản tại Trego E-Commerce.<br>
                Nếu không phải bạn đăng ký, vui lòng bỏ qua email này.
            </p>
        </div>
    </div>
</body>
</html>
