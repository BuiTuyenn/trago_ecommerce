<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get categories for products
        $phoneCategory = Category::where('name', 'Điện thoại di động')->first();
        $laptopCategory = Category::where('name', 'Laptop')->first();
        $fashionMaleCategory = Category::where('name', 'Quần áo nam')->first();
        $fashionFemaleCategory = Category::where('name', 'Quần áo nữ')->first();
        $homeCategory = Category::where('name', 'Đồ gia dụng')->first();
        $bookCategory = Category::where('name', 'Sách')->first();

        $products = [
            // Điện thoại
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => Str::slug('iPhone 15 Pro Max'),
                'description' => 'iPhone 15 Pro Max với chip A17 Pro, camera 48MP, màn hình Super Retina XDR 6.7 inch, pin trâu, thiết kế titanium cao cấp.',
                'short_description' => 'iPhone 15 Pro Max - Đỉnh cao công nghệ Apple',
                'sku' => 'IP15PM-256-NT',
                'price' => 34990000,
                'sale_price' => 32990000,
                'stock_quantity' => 50,
                'category_id' => $phoneCategory->id,
                'images' => json_encode([
                    'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-natural-titanium-1-1.jpg',
                    'https://cdn.tgdd.vn/Products/Images/42/305658/iphone-15-pro-max-natural-titanium-2.jpg'
                ]),
                'weight' => 221.00,
                'dimensions' => '159.9 x 76.7 x 8.25 mm',
                'featured' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => Str::slug('Samsung Galaxy S24 Ultra'),
                'description' => 'Galaxy S24 Ultra với bút S Pen tích hợp, camera 200MP, màn hình Dynamic AMOLED 6.8 inch, chip Snapdragon 8 Gen 3.',
                'short_description' => 'Galaxy S24 Ultra - Sức mạnh AI đỉnh cao',
                'sku' => 'SS24U-256-BK',
                'price' => 31990000,
                'sale_price' => 29990000,
                'stock_quantity' => 30,
                'category_id' => $phoneCategory->id,
                'images' => json_encode([
                    'https://cdn.tgdd.vn/Products/Images/42/307174/samsung-galaxy-s24-ultra-grey-1-1.jpg',
                    'https://cdn.tgdd.vn/Products/Images/42/307174/samsung-galaxy-s24-ultra-grey-2.jpg'
                ]),
                'weight' => 232.00,
                'dimensions' => '162.3 x 79.0 x 8.6 mm',
                'featured' => true,
                'status' => 'active'
            ],
            
            // Laptop
            [
                'name' => 'MacBook Air M2 13 inch',
                'slug' => Str::slug('MacBook Air M2 13 inch'),
                'description' => 'MacBook Air M2 với chip Apple M2 8-core, RAM 8GB, SSD 256GB, màn hình Liquid Retina 13.6 inch, thiết kế mỏng nhẹ.',
                'short_description' => 'MacBook Air M2 - Hiệu năng vượt trội, pin cực trâu',
                'sku' => 'MBA-M2-256-SG',
                'price' => 28990000,
                'sale_price' => 26990000,
                'stock_quantity' => 25,
                'category_id' => $laptopCategory->id,
                'images' => json_encode([
                    'https://cdn.tgdd.vn/Products/Images/44/282827/macbook-air-13-inch-m2-2022-starlight-1.jpg',
                    'https://cdn.tgdd.vn/Products/Images/44/282827/macbook-air-13-inch-m2-2022-starlight-2.jpg'
                ]),
                'weight' => 1240.00,
                'dimensions' => '304.1 x 215.0 x 11.3 mm',
                'featured' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Dell XPS 13 Plus',
                'slug' => Str::slug('Dell XPS 13 Plus'),
                'description' => 'Dell XPS 13 Plus với Intel Core i7-1360P, RAM 16GB, SSD 512GB, màn hình OLED 13.4 inch 3.5K, thiết kế premium.',
                'short_description' => 'Dell XPS 13 Plus - Laptop cao cấp cho doanh nhân',
                'sku' => 'DELL-XPS13P-512',
                'price' => 45990000,
                'stock_quantity' => 15,
                'category_id' => $laptopCategory->id,
                'images' => json_encode([
                    'https://cdn.tgdd.vn/Products/Images/44/289525/dell-xps-13-plus-9320-i7-71003776-1.jpg',
                    'https://cdn.tgdd.vn/Products/Images/44/289525/dell-xps-13-plus-9320-i7-71003776-2.jpg'
                ]),
                'weight' => 1260.00,
                'dimensions' => '295.3 x 199.04 x 15.28 mm',
                'featured' => false,
                'status' => 'active'
            ],

            // Thời trang nam
            [
                'name' => 'Áo sơ mi nam Oxford trắng',
                'slug' => Str::slug('Áo sơ mi nam Oxford trắng'),
                'description' => 'Áo sơ mi nam chất liệu cotton Oxford cao cấp, form slim fit, phù hợp đi làm và dự tiệc. Dễ ủi, không nhăn.',
                'short_description' => 'Áo sơ mi Oxford - Lịch lãm và thanh lịch',
                'sku' => 'SM-NAM-OX-TR-L',
                'price' => 450000,
                'sale_price' => 350000,
                'stock_quantity' => 100,
                'category_id' => $fashionMaleCategory->id,
                'images' => json_encode([
                    'https://routine.vn/media/amasty/webp/catalog/product/cache/5b1f93f7ca9b3b8b8e3b9e1b5c5e0c0c/a/o/ao-so-mi-nam-trang_1_.webp',
                    'https://routine.vn/media/amasty/webp/catalog/product/cache/5b1f93f7ca9b3b8b8e3b9e1b5c5e0c0c/a/o/ao-so-mi-nam-trang_2_.webp'
                ]),
                'weight' => 0.25,
                'dimensions' => 'Size: S, M, L, XL, XXL',
                'featured' => false,
                'status' => 'active'
            ],
            [
                'name' => 'Quần jeans nam skinny fit',
                'slug' => Str::slug('Quần jeans nam skinny fit'),
                'description' => 'Quần jeans nam form skinny fit, chất liệu denim co giãn, màu xanh đậm cổ điển. Phù hợp với nhiều phong cách.',
                'short_description' => 'Quần jeans skinny - Phong cách trẻ trung',
                'sku' => 'QJ-NAM-SK-XD-32',
                'price' => 750000,
                'sale_price' => 600000,
                'stock_quantity' => 80,
                'category_id' => $fashionMaleCategory->id,
                'images' => json_encode([
                    'https://canifa.com/img/1000/1500/resize/8/j/8jn23w001-sb001-1.webp',
                    'https://canifa.com/img/1000/1500/resize/8/j/8jn23w001-sb001-2.webp'
                ]),
                'weight' => 0.65,
                'dimensions' => 'Size: 28, 29, 30, 31, 32, 33, 34',
                'featured' => false,
                'status' => 'active'
            ],

            // Thời trang nữ
            [
                'name' => 'Váy maxi hoa nhí',
                'slug' => Str::slug('Váy maxi hoa nhí'),
                'description' => 'Váy maxi họa tiết hoa nhí dễ thương, chất liệu voan mềm mại, phù hợp dạo phố và đi du lịch. Thiết kế nữ tính.',
                'short_description' => 'Váy maxi hoa nhí - Nữ tính và quyến rũ',
                'sku' => 'VM-NU-HN-HG-M',
                'price' => 520000,
                'sale_price' => 420000,
                'stock_quantity' => 60,
                'category_id' => $fashionFemaleCategory->id,
                'images' => json_encode([
                    'https://cf.shopee.vn/file/7c1f1b1b1b1b1b1b1b1b1b1b1b1b1b1b',
                    'https://cf.shopee.vn/file/8d2f2c2c2c2c2c2c2c2c2c2c2c2c2c2c'
                ]),
                'weight' => 0.35,
                'dimensions' => 'Size: S, M, L, XL',
                'featured' => true,
                'status' => 'active'
            ],

            // Đồ gia dụng
            [
                'name' => 'Nồi cơm điện Panasonic 1.8L',
                'slug' => Str::slug('Nồi cơm điện Panasonic 1.8L'),
                'description' => 'Nồi cơm điện Panasonic 1.8L với công nghệ nấu 3D, lòng nồi chống dính cao cấp, nấu cơm ngon và đều.',
                'short_description' => 'Nồi cơm Panasonic - Cơm ngon mỗi ngày',
                'sku' => 'NCD-PAN-18L-WH',
                'price' => 2890000,
                'sale_price' => 2590000,
                'stock_quantity' => 40,
                'category_id' => $homeCategory->id,
                'images' => json_encode([
                    'https://cdn.tgdd.vn/Products/Images/1922/78870/noi-com-dien-panasonic-18-lit-sr-ms189wra-1.jpg',
                    'https://cdn.tgdd.vn/Products/Images/1922/78870/noi-com-dien-panasonic-18-lit-sr-ms189wra-2.jpg'
                ]),
                'weight' => 3.2,
                'dimensions' => '345 x 285 x 215 mm',
                'featured' => false,
                'status' => 'active'
            ],

            // Sách
            [
                'name' => 'Đắc Nhân Tâm - Dale Carnegie',
                'slug' => Str::slug('Đắc Nhân Tâm - Dale Carnegie'),
                'description' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử. Giúp bạn thành công trong công việc và cuộc sống.',
                'short_description' => 'Đắc Nhân Tâm - Bí quyết thành công',
                'sku' => 'BOOK-DNT-DC-VN',
                'price' => 120000,
                'sale_price' => 95000,
                'stock_quantity' => 200,
                'category_id' => $bookCategory->id,
                'images' => json_encode([
                    'https://cdn0.fahasa.com/media/catalog/product/d/a/dac-nhan-tam.jpg',
                    'https://cdn0.fahasa.com/media/catalog/product/d/a/dac-nhan-tam-2.jpg'
                ]),
                'weight' => 0.4,
                'dimensions' => '20.5 x 13 x 2 cm',
                'featured' => true,
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
