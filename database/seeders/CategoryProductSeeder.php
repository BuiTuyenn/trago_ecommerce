<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'sach' => [
                'name' => 'Sách',
                'products' => [
                    ['name' => 'Đắc Nhân Tâm', 'price' => 86000, 'sale_price' => 69000, 'description' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử'],
                    ['name' => 'Sapiens - Lược Sử Loài Người', 'price' => 199000, 'sale_price' => 159000, 'description' => 'Cuộc hành trình từ động vật không đáng kể đến chúa tể địa cầu'],
                    ['name' => 'Atomic Habits', 'price' => 149000, 'sale_price' => 119000, 'description' => 'Cách xây dựng thói quen tốt và loại bỏ thói quen xấu'],
                    ['name' => 'The Lean Startup', 'price' => 179000, 'sale_price' => 143000, 'description' => 'Cách các doanh nhân hiện đại sử dụng đổi mới liên tục'],
                    ['name' => 'Tôi Tài Giỏi, Bạn Cũng Thế', 'price' => 89000, 'sale_price' => 71000, 'description' => 'Phương pháp học tập hiệu quả từ Adam Khoo'],
                    ['name' => 'Rich Dad Poor Dad', 'price' => 119000, 'sale_price' => 95000, 'description' => 'Những bài học về tiền bạc mà nhà trường không dạy'],
                    ['name' => 'Thinking Fast and Slow', 'price' => 189000, 'sale_price' => 151000, 'description' => 'Hai hệ thống tư duy trong não bộ con người'],
                    ['name' => 'The 7 Habits of Highly Effective People', 'price' => 159000, 'sale_price' => 127000, 'description' => '7 thói quen của người thành đạt'],
                    ['name' => 'Start With Why', 'price' => 139000, 'sale_price' => 111000, 'description' => 'Làm thế nào các nhà lãnh đạo vĩ đại truyền cảm hứng'],
                    ['name' => 'Good to Great', 'price' => 169000, 'sale_price' => 135000, 'description' => 'Tại sao một số công ty thành công vượt trội'],
                    ['name' => 'The Power of Now', 'price' => 129000, 'sale_price' => 103000, 'description' => 'Hướng dẫn đến sự giác ngộ tâm linh'],
                    ['name' => 'Zero to One', 'price' => 149000, 'sale_price' => 119000, 'description' => 'Ghi chú về khởi nghiệp, hoặc cách xây dựng tương lai'],
                    ['name' => 'The Alchemist', 'price' => 99000, 'sale_price' => 79000, 'description' => 'Nhà giả kim - Cuộc phiêu lưu tìm kiếm kho báu'],
                    ['name' => 'Mindset', 'price' => 139000, 'sale_price' => 111000, 'description' => 'Tâm lý học thành công'],
                    ['name' => 'The 4-Hour Workweek', 'price' => 159000, 'sale_price' => 127000, 'description' => 'Thoát khỏi cuộc sống 9-5, sống ở bất cứ đâu'],
                    ['name' => 'Think and Grow Rich', 'price' => 109000, 'sale_price' => 87000, 'description' => 'Nghĩ giàu và làm giàu'],
                    ['name' => 'The Subtle Art of Not Giving a F*ck', 'price' => 149000, 'sale_price' => 119000, 'description' => 'Nghệ thuật tinh tế của việc đừng quan tâm'],
                    ['name' => 'Dune', 'price' => 199000, 'sale_price' => 159000, 'description' => 'Tiểu thuyết khoa học viễn tưởng kinh điển'],
                    ['name' => 'Harry Potter và Hòn đá Phù thủy', 'price' => 129000, 'sale_price' => 103000, 'description' => 'Cuộc phiêu lưu đầu tiên của Harry Potter'],
                    ['name' => 'Sherlock Holmes Toàn tập', 'price' => 299000, 'sale_price' => 239000, 'description' => 'Bộ sưu tập đầy đủ các vụ án của thám tử Sherlock Holmes'],
                ]
            ],
            'dien-thoai' => [
                'name' => 'Điện thoại',
                'products' => [
                    ['name' => 'iPhone 15 Pro Max 256GB', 'price' => 34990000, 'sale_price' => 33490000, 'description' => 'iPhone 15 Pro Max với chip A17 Pro, camera 48MP'],
                    ['name' => 'Samsung Galaxy S24 Ultra 512GB', 'price' => 32990000, 'sale_price' => 31490000, 'description' => 'Galaxy S24 Ultra với S Pen, camera 200MP'],
                    ['name' => 'iPhone 14 Pro 128GB', 'price' => 27990000, 'sale_price' => 26490000, 'description' => 'iPhone 14 Pro với Dynamic Island, camera 48MP'],
                    ['name' => 'Samsung Galaxy S23 256GB', 'price' => 20990000, 'sale_price' => 19490000, 'description' => 'Galaxy S23 với chip Snapdragon 8 Gen 2'],
                    ['name' => 'Xiaomi 14 Ultra 512GB', 'price' => 25990000, 'sale_price' => 24490000, 'description' => 'Xiaomi 14 Ultra với camera Leica'],
                    ['name' => 'OPPO Find X7 Ultra 256GB', 'price' => 23990000, 'sale_price' => 22490000, 'description' => 'OPPO Find X7 Ultra với camera Hasselblad'],
                    ['name' => 'Vivo X100 Pro 256GB', 'price' => 22990000, 'sale_price' => 21490000, 'description' => 'Vivo X100 Pro với chip MediaTek Dimensity 9300'],
                    ['name' => 'Google Pixel 8 Pro 256GB', 'price' => 24990000, 'sale_price' => 23490000, 'description' => 'Google Pixel 8 Pro với AI tích hợp'],
                    ['name' => 'OnePlus 12 256GB', 'price' => 21990000, 'sale_price' => 20490000, 'description' => 'OnePlus 12 với sạc nhanh 100W'],
                    ['name' => 'iPhone 13 128GB', 'price' => 18990000, 'sale_price' => 17490000, 'description' => 'iPhone 13 với chip A15 Bionic'],
                    ['name' => 'Samsung Galaxy A55 128GB', 'price' => 9990000, 'sale_price' => 8990000, 'description' => 'Galaxy A55 với camera 50MP'],
                    ['name' => 'Xiaomi Redmi Note 13 Pro 256GB', 'price' => 7990000, 'sale_price' => 6990000, 'description' => 'Redmi Note 13 Pro với camera 200MP'],
                    ['name' => 'OPPO Reno11 F 256GB', 'price' => 8990000, 'sale_price' => 7990000, 'description' => 'OPPO Reno11 F với thiết kế mỏng nhẹ'],
                    ['name' => 'Vivo Y36 128GB', 'price' => 5990000, 'sale_price' => 4990000, 'description' => 'Vivo Y36 với pin 5000mAh'],
                    ['name' => 'Realme 11 Pro+ 256GB', 'price' => 9990000, 'sale_price' => 8490000, 'description' => 'Realme 11 Pro+ với camera 200MP'],
                    ['name' => 'Nothing Phone (2) 256GB', 'price' => 16990000, 'sale_price' => 15490000, 'description' => 'Nothing Phone (2) với thiết kế trong suốt'],
                    ['name' => 'Honor Magic6 Pro 512GB', 'price' => 26990000, 'sale_price' => 25490000, 'description' => 'Honor Magic6 Pro với AI photography'],
                    ['name' => 'Asus ROG Phone 8 Pro 512GB', 'price' => 29990000, 'sale_price' => 28490000, 'description' => 'ROG Phone 8 Pro dành cho game thủ'],
                    ['name' => 'Sony Xperia 1 V 256GB', 'price' => 27990000, 'sale_price' => 26490000, 'description' => 'Sony Xperia 1 V với camera chuyên nghiệp'],
                    ['name' => 'Motorola Edge 50 Pro 256GB', 'price' => 12990000, 'sale_price' => 11490000, 'description' => 'Motorola Edge 50 Pro với màn hình cong'],
                ]
            ],
            'laptop' => [
                'name' => 'Laptop',
                'products' => [
                    ['name' => 'MacBook Pro 16" M3 Max 1TB', 'price' => 89990000, 'sale_price' => 85990000, 'description' => 'MacBook Pro 16" với chip M3 Max, 36GB RAM'],
                    ['name' => 'MacBook Air 15" M2 512GB', 'price' => 34990000, 'sale_price' => 32990000, 'description' => 'MacBook Air 15" với chip M2, siêu mỏng nhẹ'],
                    ['name' => 'Dell XPS 13 Plus Intel i7 1TB', 'price' => 45990000, 'sale_price' => 42990000, 'description' => 'Dell XPS 13 Plus với Intel Core i7 gen 13'],
                    ['name' => 'ASUS ROG Strix G16 RTX 4070', 'price' => 42990000, 'sale_price' => 39990000, 'description' => 'Gaming laptop với RTX 4070, Intel i7'],
                    ['name' => 'HP Spectre x360 14" OLED', 'price' => 38990000, 'sale_price' => 35990000, 'description' => 'HP Spectre x360 với màn hình OLED 2.8K'],
                    ['name' => 'Lenovo ThinkPad X1 Carbon Gen 11', 'price' => 49990000, 'sale_price' => 46990000, 'description' => 'ThinkPad X1 Carbon với Intel vPro'],
                    ['name' => 'ASUS ZenBook Pro 16X OLED', 'price' => 52990000, 'sale_price' => 49990000, 'description' => 'ZenBook Pro với OLED 4K, RTX 4060'],
                    ['name' => 'MSI Creator Z17 HX Studio', 'price' => 67990000, 'sale_price' => 63990000, 'description' => 'MSI Creator cho content creator, RTX 4080'],
                    ['name' => 'Surface Laptop Studio 2', 'price' => 54990000, 'sale_price' => 51990000, 'description' => 'Surface Laptop Studio với RTX 4050'],
                    ['name' => 'Razer Blade 15 Advanced', 'price' => 59990000, 'sale_price' => 56990000, 'description' => 'Razer Blade 15 với RTX 4070, QHD 240Hz'],
                    ['name' => 'Acer Predator Helios 16', 'price' => 36990000, 'sale_price' => 33990000, 'description' => 'Gaming laptop Predator với RTX 4060'],
                    ['name' => 'Gigabyte AERO 16 OLED', 'price' => 48990000, 'sale_price' => 45990000, 'description' => 'AERO 16 với OLED 4K, RTX 4070'],
                    ['name' => 'LG Gram 17" Ultra-light', 'price' => 32990000, 'sale_price' => 29990000, 'description' => 'LG Gram 17" siêu nhẹ chỉ 1.35kg'],
                    ['name' => 'ASUS VivoBook Pro 15 OLED', 'price' => 24990000, 'sale_price' => 21990000, 'description' => 'VivoBook Pro với OLED 2.8K'],
                    ['name' => 'HP Envy x360 15" AMD', 'price' => 22990000, 'sale_price' => 19990000, 'description' => 'HP Envy x360 với AMD Ryzen 7'],
                    ['name' => 'Lenovo Legion 5 Pro RTX 4060', 'price' => 34990000, 'sale_price' => 31990000, 'description' => 'Legion 5 Pro gaming laptop'],
                    ['name' => 'Dell Inspiron 16 Plus', 'price' => 26990000, 'sale_price' => 23990000, 'description' => 'Dell Inspiron 16 Plus với Intel i7'],
                    ['name' => 'ASUS TUF Gaming A15', 'price' => 19990000, 'sale_price' => 17990000, 'description' => 'TUF Gaming với AMD Ryzen 7, GTX 1650'],
                    ['name' => 'Acer Swift 3 AMD Ryzen 5', 'price' => 16990000, 'sale_price' => 14990000, 'description' => 'Acer Swift 3 văn phòng, AMD Ryzen 5'],
                    ['name' => 'HP Pavilion Gaming 15', 'price' => 18990000, 'sale_price' => 16990000, 'description' => 'HP Pavilion Gaming với GTX 1650'],
                ]
            ],
            'me-be' => [
                'name' => 'Mẹ & Bé',
                'products' => [
                    ['name' => 'Xe đẩy em bé Combi Mechacargo', 'price' => 8990000, 'sale_price' => 7990000, 'description' => 'Xe đẩy cao cấp từ Nhật Bản, gấp gọn'],
                    ['name' => 'Ghế ngồi ô tô Joie i-Gemm 3', 'price' => 4990000, 'sale_price' => 4490000, 'description' => 'Ghế ngồi ô tô an toàn cho trẻ 0-15 tháng'],
                    ['name' => 'Máy hút sữa điện đôi Spectra S1+', 'price' => 6990000, 'sale_price' => 6490000, 'description' => 'Máy hút sữa điện đôi có pin sạc'],
                    ['name' => 'Nôi điện tự động RONBEI', 'price' => 12990000, 'sale_price' => 11990000, 'description' => 'Nôi điện tự động ru em bé ngủ'],
                    ['name' => 'Tã dán Pampers Premium Care NB', 'price' => 449000, 'sale_price' => 399000, 'description' => 'Tã dán cao cấp cho trẻ sơ sinh 84 miếng'],
                    ['name' => 'Sữa bột Aptamil Gold+ số 1', 'price' => 789000, 'sale_price' => 699000, 'description' => 'Sữa bột cho trẻ 0-6 tháng tuổi 900g'],
                    ['name' => 'Bình sữa Pigeon PPSU 240ml', 'price' => 299000, 'sale_price' => 259000, 'description' => 'Bình sữa PPSU cao cấp chống đầy hơi'],
                    ['name' => 'Máy tiệt trùng sấy khô Fatzbaby', 'price' => 2990000, 'sale_price' => 2690000, 'description' => 'Máy tiệt trùng và sấy khô đa năng'],
                    ['name' => 'Xe lắc em bé Nhựa Chợ Lớn', 'price' => 599000, 'sale_price' => 499000, 'description' => 'Xe lắc cho bé tập đi an toàn'],
                    ['name' => 'Ghế ăn dặm Chicco Polly Easy', 'price' => 3490000, 'sale_price' => 2990000, 'description' => 'Ghế ăn dặm có thể điều chỉnh độ cao'],
                    ['name' => 'Cũi gỗ cho bé Umoo UMO-686', 'price' => 5990000, 'sale_price' => 5490000, 'description' => 'Cũi gỗ tự nhiên an toàn cho bé'],
                    ['name' => 'Đồ chơi xúc xắc Fisher Price', 'price' => 199000, 'sale_price' => 169000, 'description' => 'Đồ chơi phát triển trí tuệ cho bé'],
                    ['name' => 'Áo liền quần cotton Mamamy', 'price' => 89000, 'sale_price' => 69000, 'description' => 'Bộ áo liền quần cotton mềm mại'],
                    ['name' => 'Tã quần Huggies Dry Pants L', 'price' => 379000, 'sale_price' => 339000, 'description' => 'Tã quần siêu thấm hút 62 miếng'],
                    ['name' => 'Sữa tắm gội Johnson Baby', 'price' => 129000, 'sale_price' => 99000, 'description' => 'Sữa tắm gội 2 trong 1 cho bé 500ml'],
                    ['name' => 'Máy đo nhiệt độ hồng ngoại Omron', 'price' => 1290000, 'sale_price' => 1190000, 'description' => 'Máy đo nhiệt độ không tiếp xúc'],
                    ['name' => 'Gối chống trào ngược Latex', 'price' => 399000, 'sale_price' => 349000, 'description' => 'Gối chống trào ngược cho bé sơ sinh'],
                    ['name' => 'Xe đạp trẻ em Royal Baby 16"', 'price' => 2990000, 'sale_price' => 2690000, 'description' => 'Xe đạp cho trẻ 4-7 tuổi có bánh phụ'],
                    ['name' => 'Túi xách đựng đồ mẹ và bé', 'price' => 699000, 'sale_price' => 599000, 'description' => 'Túi xách đa năng cho mẹ bỉm sữa'],
                    ['name' => 'Kệ sách gỗ cho bé Montessori', 'price' => 1990000, 'sale_price' => 1790000, 'description' => 'Kệ sách theo phương pháp Montessori'],
                ]
            ],
            'thoi-trang-nu' => [
                'name' => 'Thời trang nữ',
                'products' => [
                    ['name' => 'Váy dạ hội lụa cao cấp', 'price' => 2990000, 'sale_price' => 2490000, 'description' => 'Váy dạ hội lụa tơ tằm thiết kế thanh lịch'],
                    ['name' => 'Áo blazer nữ công sở', 'price' => 1290000, 'sale_price' => 990000, 'description' => 'Áo blazer nữ phong cách công sở hiện đại'],
                    ['name' => 'Quần jean skinny nữ', 'price' => 699000, 'sale_price' => 549000, 'description' => 'Quần jean skinny co giãn thoải mái'],
                    ['name' => 'Đầm maxi hoa nhí', 'price' => 899000, 'sale_price' => 699000, 'description' => 'Đầm maxi họa tiết hoa nhí nữ tính'],
                    ['name' => 'Áo sơ mi trắng basic', 'price' => 499000, 'sale_price' => 399000, 'description' => 'Áo sơ mi trắng basic không thể thiếu'],
                    ['name' => 'Chân váy chữ A midi', 'price' => 599000, 'sale_price' => 479000, 'description' => 'Chân váy chữ A dáng midi thanh lịch'],
                    ['name' => 'Áo len cổ lọ nữ', 'price' => 799000, 'sale_price' => 639000, 'description' => 'Áo len cổ lọ ấm áp mùa đông'],
                    ['name' => 'Đầm bodycon đen', 'price' => 1199000, 'sale_price' => 959000, 'description' => 'Đầm bodycon đen quyến rũ'],
                    ['name' => 'Quần tây nữ ống rộng', 'price' => 899000, 'sale_price' => 719000, 'description' => 'Quần tây nữ ống rộng xu hướng 2024'],
                    ['name' => 'Áo khoác denim nữ', 'price' => 999000, 'sale_price' => 799000, 'description' => 'Áo khoác denim phong cách vintage'],
                    ['name' => 'Set đồ thể thao nữ', 'price' => 699000, 'sale_price' => 559000, 'description' => 'Set đồ thể thao yoga thoáng mát'],
                    ['name' => 'Đầm suông tay dài', 'price' => 799000, 'sale_price' => 639000, 'description' => 'Đầm suông tay dài phong cách Hàn Quốc'],
                    ['name' => 'Áo crop top nữ', 'price' => 299000, 'sale_price' => 239000, 'description' => 'Áo crop top sexy cho mùa hè'],
                    ['name' => 'Quần short jean nữ', 'price' => 399000, 'sale_price' => 319000, 'description' => 'Quần short jean rách phong cách'],
                    ['name' => 'Áo kiểu nữ cổ V', 'price' => 599000, 'sale_price' => 479000, 'description' => 'Áo kiểu nữ cổ V thanh lịch'],
                    ['name' => 'Chân váy jean chữ A', 'price' => 699000, 'sale_price' => 559000, 'description' => 'Chân váy jean chữ A trẻ trung'],
                    ['name' => 'Áo hoodie nữ oversize', 'price' => 899000, 'sale_price' => 719000, 'description' => 'Áo hoodie oversize phong cách streetwear'],
                    ['name' => 'Jumpsuit nữ dài tay', 'price' => 1299000, 'sale_price' => 1039000, 'description' => 'Jumpsuit nữ dài tay sang trọng'],
                    ['name' => 'Áo cardigan dáng dài', 'price' => 1099000, 'sale_price' => 879000, 'description' => 'Áo cardigan dáng dài ấm áp'],
                    ['name' => 'Set đồ ngủ lụa', 'price' => 799000, 'sale_price' => 639000, 'description' => 'Set đồ ngủ lụa cao cấp mềm mại'],
                ]
            ],
            'thoi-trang-nam' => [
                'name' => 'Thời trang nam',
                'products' => [
                    ['name' => 'Suit nam cao cấp', 'price' => 4990000, 'sale_price' => 3990000, 'description' => 'Bộ suit nam cao cấp may đo'],
                    ['name' => 'Áo sơ mi nam trắng', 'price' => 699000, 'sale_price' => 559000, 'description' => 'Áo sơ mi nam trắng công sở'],
                    ['name' => 'Quần jean nam straight', 'price' => 899000, 'sale_price' => 719000, 'description' => 'Quần jean nam dáng straight classic'],
                    ['name' => 'Áo polo nam cao cấp', 'price' => 599000, 'sale_price' => 479000, 'description' => 'Áo polo nam cotton cao cấp'],
                    ['name' => 'Áo khoác bomber nam', 'price' => 1299000, 'sale_price' => 1039000, 'description' => 'Áo khoác bomber nam phong cách'],
                    ['name' => 'Quần kaki nam slim fit', 'price' => 799000, 'sale_price' => 639000, 'description' => 'Quần kaki nam dáng slim fit'],
                    ['name' => 'Áo thun nam basic', 'price' => 299000, 'sale_price' => 239000, 'description' => 'Áo thun nam basic cotton 100%'],
                    ['name' => 'Áo hoodie nam unisex', 'price' => 999000, 'sale_price' => 799000, 'description' => 'Áo hoodie nam unisex streetwear'],
                    ['name' => 'Quần short nam kaki', 'price' => 499000, 'sale_price' => 399000, 'description' => 'Quần short nam kaki mùa hè'],
                    ['name' => 'Áo vest nam công sở', 'price' => 2499000, 'sale_price' => 1999000, 'description' => 'Áo vest nam công sở thanh lịch'],
                    ['name' => 'Áo len nam cổ tròn', 'price' => 899000, 'sale_price' => 719000, 'description' => 'Áo len nam cổ tròn ấm áp'],
                    ['name' => 'Quần jogger nam', 'price' => 699000, 'sale_price' => 559000, 'description' => 'Quần jogger nam thể thao'],
                    ['name' => 'Áo tank top nam', 'price' => 199000, 'sale_price' => 159000, 'description' => 'Áo tank top nam mùa hè'],
                    ['name' => 'Quần tây nam công sở', 'price' => 1199000, 'sale_price' => 959000, 'description' => 'Quần tây nam công sở cao cấp'],
                    ['name' => 'Áo cardigan nam', 'price' => 1299000, 'sale_price' => 1039000, 'description' => 'Áo cardigan nam dáng dài'],
                    ['name' => 'Set đồ thể thao nam', 'price' => 899000, 'sale_price' => 719000, 'description' => 'Set đồ thể thao nam thoáng mát'],
                    ['name' => 'Áo sơ mi nam kẻ sọc', 'price' => 799000, 'sale_price' => 639000, 'description' => 'Áo sơ mi nam kẻ sọc phong cách'],
                    ['name' => 'Quần jean nam rách', 'price' => 999000, 'sale_price' => 799000, 'description' => 'Quần jean nam rách phong cách'],
                    ['name' => 'Áo blazer nam casual', 'price' => 1899000, 'sale_price' => 1519000, 'description' => 'Áo blazer nam phong cách casual'],
                    ['name' => 'Đồ ngủ nam cotton', 'price' => 599000, 'sale_price' => 479000, 'description' => 'Bộ đồ ngủ nam cotton thoải mái'],
                ]
            ]
        ];

        foreach ($categories as $categorySlug => $categoryData) {
            $category = Category::where('slug', $categorySlug)->first();
            if (!$category) {
                $category = Category::create([
                    'name' => $categoryData['name'],
                    'slug' => $categorySlug,
                    'description' => 'Danh mục ' . $categoryData['name'],
                    'is_active' => true,
                    'sort_order' => 1,
                ]);
            }

            foreach ($categoryData['products'] as $productData) {
                Product::create([
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'short_description' => substr($productData['description'], 0, 100),
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'],
                    'category_id' => $category->id,
                    'sku' => 'SKU-' . strtoupper(Str::random(8)),
                    'stock_quantity' => rand(10, 100),
                    'manage_stock' => true,
                    'in_stock' => true,
                    'images' => json_encode(['placeholder.jpg']),
                    'status' => 'active',
                    'featured' => rand(0, 1) == 1,
                    'weight' => rand(100, 2000),
                    'dimensions' => json_encode(['length' => rand(10, 50), 'width' => rand(10, 50), 'height' => rand(5, 30)]),
                ]);
            }
        }
    }
}
