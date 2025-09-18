<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Điện thoại & Phụ kiện',
                'description' => 'Điện thoại thông minh, phụ kiện điện thoại',
                'sort_order' => 1,
                'children' => [
                    'Điện thoại di động',
                    'Ốp lưng & Bao da',
                    'Cáp sạc & Adapter',
                    'Tai nghe',
                ]
            ],
            [
                'name' => 'Laptop & Máy tính',
                'description' => 'Laptop, máy tính để bàn, linh kiện máy tính',
                'sort_order' => 2,
                'children' => [
                    'Laptop',
                    'Máy tính để bàn',
                    'Linh kiện máy tính',
                    'Phần mềm',
                ]
            ],
            [
                'name' => 'Thời trang',
                'description' => 'Quần áo, giày dép, phụ kiện thời trang',
                'sort_order' => 3,
                'children' => [
                    'Quần áo nam',
                    'Quần áo nữ',
                    'Giày dép',
                    'Túi xách',
                ]
            ],
            [
                'name' => 'Gia dụng & Đời sống',
                'description' => 'Đồ gia dụng, nội thất, trang trí nhà cửa',
                'sort_order' => 4,
                'children' => [
                    'Đồ gia dụng',
                    'Nội thất',
                    'Trang trí nhà cửa',
                    'Đèn & Chiếu sáng',
                ]
            ],
            [
                'name' => 'Sách & Văn phòng phẩm',
                'description' => 'Sách, văn phòng phẩm, dụng cụ học tập',
                'sort_order' => 5,
                'children' => [
                    'Sách',
                    'Văn phòng phẩm',
                    'Dụng cụ học tập',
                    'Máy văn phòng',
                ]
            ],
            [
                'name' => 'Thể thao & Du lịch',
                'description' => 'Dụng cụ thể thao, đồ du lịch',
                'sort_order' => 6,
                'children' => [
                    'Dụng cụ thể thao',
                    'Đồ du lịch',
                    'Xe đạp',
                    'Cắm trại & Dã ngoại',
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'sort_order' => $categoryData['sort_order'],
                'is_active' => true,
            ]);

            // Create child categories
            foreach ($categoryData['children'] as $index => $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'description' => "Danh mục con của {$categoryData['name']}",
                    'parent_id' => $category->id,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
