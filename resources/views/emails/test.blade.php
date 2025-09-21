<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email - Trego E-Commerce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .highlight {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196f3;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Chúc mừng!</h1>
        <h2>Email cấu hình thành công</h2>
    </div>
    
    <div class="content">
        <h3>Xin chào!</h3>
        
        <p>Đây là email test để kiểm tra cấu hình Gmail SMTP cho hệ thống <strong>Trego E-Commerce</strong>.</p>
        
        <div class="highlight">
            <strong>✅ Cấu hình thành công!</strong><br>
            Hệ thống email của bạn đã hoạt động bình thường với Gmail SMTP.
        </div>
        
        <h4>📧 Thông tin cấu hình:</h4>
        <ul>
            <li><strong>SMTP Host:</strong> smtp.gmail.com</li>
            <li><strong>Port:</strong> 587</li>
            <li><strong>Encryption:</strong> TLS</li>
            <li><strong>From Email:</strong> {{ config('mail.from.address') }}</li>
            <li><strong>From Name:</strong> {{ config('mail.from.name') }}</li>
        </ul>
        
        <h4>🚀 Các chức năng email sẵn sàng:</h4>
        <ul>
            <li>✅ Email xác thực tài khoản</li>
            <li>✅ Email reset mật khẩu</li>
            <li>✅ Email thông báo đơn hàng</li>
            <li>✅ Email marketing</li>
        </ul>
        
        <p><strong>Thời gian gửi:</strong> {{ now()->format('d/m/Y H:i:s') }} (GMT+7)</p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Trego E-Commerce. All rights reserved.</p>
        <p>Email này được gửi tự động từ hệ thống.</p>
    </div>
</body>
</html>
