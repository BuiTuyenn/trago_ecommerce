<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái Email - Trego E-Commerce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .success-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-box {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h2>📧 Trạng thái gửi email - Trego E-Commerce</h2>
    
    <div class="success-box">
        <h3>✅ Email đã được gửi thành công!</h3>
        <p>Chúng tôi đã gửi email chào mừng đến địa chỉ email của bạn.</p>
    </div>
    
    <div class="info-box">
        <h4>📬 Những gì bạn sẽ nhận được:</h4>
        <ul>
            <li>✉️ <strong>Email xác thực tài khoản</strong> - Click để kích hoạt tài khoản</li>
            <li>🎉 <strong>Email chào mừng</strong> - Thông tin về Trego và ưu đãi đặc biệt</li>
            <li>🔔 <strong>Thông báo đơn hàng</strong> - Khi bạn mua sắm</li>
        </ul>
    </div>
    
    <div class="highlight">
        <h4>⚠️ Lưu ý quan trọng:</h4>
        <ul>
            <li>Kiểm tra cả hộp thư <strong>Spam/Junk</strong> nếu không thấy email</li>
            <li>Email từ: <strong>buituyenkc2004@gmail.com</strong></li>
            <li>Thời gian gửi: <strong>{{ now()->format('d/m/Y H:i:s') }} (GMT+7)</strong></li>
        </ul>
    </div>
    
    <p>Cảm ơn bạn đã tham gia cộng đồng Trego E-Commerce! 🛒</p>
</body>
</html>
