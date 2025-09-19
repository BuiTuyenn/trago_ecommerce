<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductsDienThoai;
use App\Models\Category;

class DienThoaiProductsSeeder extends Seeder
{
    public function run()
    {
        // Tạo hoặc lấy category Điện Thoại
        $phoneCategory = Category::firstOrCreate([
            'slug' => 'dien-thoai-may-tinh-bang'
        ], [
            'name' => 'Điện Thoại - Máy Tính Bảng',
            'description' => 'Smartphone, tablet và phụ kiện công nghệ',
            'is_active' => true,
            'sort_order' => 2
        ]);

        $phones = [
            [
                'name' => 'iPhone 15 Pro Max 256GB',
                'slug' => 'iphone-15-pro-max-256gb',
                'description' => 'iPhone 15 Pro Max với chip A17 Pro mạnh mẽ, camera 48MP tiên tiến, và thiết kế titanium cao cấp.',
                'short_description' => 'iPhone 15 Pro Max - Đỉnh cao công nghệ Apple',
                'sku' => 'IP15PM-256-001',
                'price' => 32990000,
                'sale_price' => 31990000,
                'stock_quantity' => 50,
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro Max',
                'device_type' => 'smartphone',
                'operating_system' => 'iOS',
                'os_version' => 'iOS 17',
                'screen_size' => 6.7,
                'screen_resolution' => '2796x1290',
                'screen_technology' => 'Super Retina XDR OLED',
                'refresh_rate' => 120,
                'brightness_nits' => 2000,
                'hdr_support' => true,
                'processor' => 'Apple A17 Pro',
                'ram_gb' => 8,
                'storage_options' => [256, 512, 1024],
                'storage_gb' => 256,
                'storage_type' => 'NVMe',
                'rear_cameras' => [
                    ['mp' => 48, 'type' => 'main'],
                    ['mp' => 12, 'type' => 'ultra_wide'],
                    ['mp' => 12, 'type' => 'telephoto']
                ],
                'front_camera_mp' => 12,
                'camera_features' => ['Night mode', 'Portrait', 'Cinematic mode', 'Action mode'],
                'video_recording_4k' => true,
                'video_recording_fps' => '60fps',
                'battery_capacity_mah' => 4441,
                'charging_speed' => '27W',
                'wireless_charging' => true,
                'reverse_charging' => false,
                'charging_port' => 'USB-C',
                'network_support' => ['5G', '4G LTE'],
                'dual_sim' => true,
                'esim_support' => true,
                'wifi_6' => true,
                'bluetooth' => true,
                'bluetooth_version' => '5.3',
                'nfc' => true,
                'biometric_features' => ['Face ID'],
                'face_unlock' => true,
                'dimensions' => '159.9 x 76.7 x 8.25 mm',
                'weight_grams' => 221.0,
                'build_material' => 'Titanium',
                'color' => 'Natural Titanium',
                'available_colors' => ['Natural Titanium', 'Blue Titanium', 'White Titanium', 'Black Titanium'],
                'water_resistance' => 'IP68',
                'category_id' => $phoneCategory->id,
                'warranty_months' => 12,
                'origin_country' => 'China',
                'condition' => 'new',
                'unlocked' => true,
                'box_contents' => ['iPhone', 'USB-C Cable', 'Documentation'],
                'charger_included' => false,
                'images' => ['/images/phones/iphone-15-pro-max.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => true,
                'new_arrival' => true,
                'flagship' => true
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra 512GB',
                'slug' => 'samsung-galaxy-s24-ultra-512gb',
                'description' => 'Galaxy S24 Ultra với S Pen tích hợp, camera 200MP và AI tiên tiến.',
                'short_description' => 'Galaxy S24 Ultra - Productivity flagship',
                'sku' => 'SGS24U-512-002',
                'price' => 29990000,
                'sale_price' => 27990000,
                'stock_quantity' => 35,
                'brand' => 'Samsung',
                'model' => 'Galaxy S24 Ultra',
                'device_type' => 'smartphone',
                'operating_system' => 'Android',
                'os_version' => 'Android 14',
                'screen_size' => 6.8,
                'screen_resolution' => '3120x1440',
                'screen_technology' => 'Dynamic AMOLED 2X',
                'refresh_rate' => 120,
                'brightness_nits' => 2600,
                'hdr_support' => true,
                'processor' => 'Snapdragon 8 Gen 3',
                'ram_gb' => 12,
                'storage_options' => [256, 512, 1024],
                'storage_gb' => 512,
                'storage_type' => 'UFS 4.0',
                'rear_cameras' => [
                    ['mp' => 200, 'type' => 'main'],
                    ['mp' => 50, 'type' => 'telephoto'],
                    ['mp' => 10, 'type' => 'telephoto'],
                    ['mp' => 12, 'type' => 'ultra_wide']
                ],
                'front_camera_mp' => 12,
                'camera_features' => ['Night mode', 'Portrait', 'Pro mode', 'Space Zoom'],
                'video_recording_4k' => true,
                'battery_capacity_mah' => 5000,
                'charging_speed' => '45W',
                'wireless_charging' => true,
                'charging_port' => 'USB-C',
                'network_support' => ['5G', '4G LTE'],
                'dual_sim' => true,
                'wifi_6' => true,
                'bluetooth' => true,
                'bluetooth_version' => '5.3',
                'nfc' => true,
                'biometric_features' => ['Fingerprint', 'Face Recognition'],
                'fingerprint_scanner' => true,
                'fingerprint_location' => 'under_display',
                'face_unlock' => true,
                'dimensions' => '162.3 x 79.0 x 8.6 mm',
                'weight_grams' => 232.0,
                'build_material' => 'Aluminum',
                'color' => 'Titanium Gray',
                'available_colors' => ['Titanium Gray', 'Titanium Black', 'Titanium Violet'],
                'water_resistance' => 'IP68',
                'category_id' => $phoneCategory->id,
                'warranty_months' => 12,
                'condition' => 'new',
                'unlocked' => true,
                'images' => ['/images/phones/galaxy-s24-ultra.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => true,
                'flagship' => true
            ]
        ];

        foreach ($phones as $phone) {
            ProductsDienThoai::create($phone);
        }
    }
}