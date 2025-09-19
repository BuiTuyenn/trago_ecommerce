<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeLivingProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];
        
        // Tạo 15 sản phẩm nhà cửa để test pagination
        $productNames = [
            'Bàn làm việc gỗ tự nhiên',
            'Ghế xoay văn phòng ergonomic',
            'Tủ quần áo 3 cánh hiện đại',
            'Giường ngủ 1m6 có hộc tủ',
            'Sofa góc L phòng khách',
            'Bàn ăn 6 ghế gỗ sồi',
            'Kệ tivi treo tường',
            'Tủ giày dép 5 tầng',
            'Nệm foam memory cao cấp',
            'Đèn chùm phòng khách LED',
            'Rèm cửa chống nắng',
            'Thảm trải sàn phòng khách',
            'Chăn ga gối cotton 100%',
            'Máy lọc không khí Xiaomi',
            'Robot hút bụi thông minh'
        ];
        
        $brands = ['IKEA', 'Hòa Phát', 'Sunhouse', 'Trego Home', 'Xiaomi'];
        
        for ($i = 0; $i < 15; $i++) {
            $products[] = [
                'name' => $productNames[$i],
                'brand' => $brands[array_rand($brands)],
                'category_id' => 2, // Home category ID
                'price' => rand(500000, 5000000),
                'sale_price' => rand(400000, 4500000),
                'stock_quantity' => rand(5, 50),
                'description' => "Sản phẩm chất lượng cao cho ngôi nhà của bạn. " . $productNames[$i] . " với thiết kế hiện đại, tiện dụng.",
                'short_description' => $productNames[$i] . " chất lượng cao",
                'primary_material' => $i % 3 == 0 ? 'Gỗ tự nhiên' : ($i % 2 == 0 ? 'Gỗ công nghiệp' : 'Kim loại'),
                'materials' => json_encode([$i % 3 == 0 ? 'Gỗ tự nhiên' : ($i % 2 == 0 ? 'Gỗ công nghiệp' : 'Kim loại')]),
                'warranty_years' => rand(1, 3),
                'dimensions' => rand(50, 200) . 'x' . rand(30, 150) . 'x' . rand(20, 100),
                'weight' => rand(5, 50),
                'available_colors' => json_encode(['Trắng', 'Đen', 'Nâu']),
                'color' => ['Trắng', 'Đen', 'Nâu'][array_rand(['Trắng', 'Đen', 'Nâu'])],
                'room_type' => ['Phòng khách', 'Phòng ngủ', 'Phòng bếp', 'Phòng làm việc'][array_rand(['Phòng khách', 'Phòng ngủ', 'Phòng bếp', 'Phòng làm việc'])],
                'product_type' => ['Nội thất', 'Đồ gia dụng', 'Thiết bị', 'Trang trí'][array_rand(['Nội thất', 'Đồ gia dụng', 'Thiết bị', 'Trang trí'])],
                'images' => json_encode(["home-living/product-" . ($i + 1) . ".jpg"]),
                'featured' => $i < 5,
                'bestseller' => $i < 8,
                'status' => 'active',
                'slug' => "home-living-product-" . ($i + 1),
                'sku' => "HL-" . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'assembly_required' => rand(0, 1),
                'eco_friendly' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products_nha_cua')->insert($products);
        
        $this->command->info('Added ' . count($products) . ' home & living products to products_nha_cua table');
    }
}
