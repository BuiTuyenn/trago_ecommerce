<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsSach;
use App\Models\Category;

class SachProductsSeeder extends Seeder
{
    public function run()
    {
        // Lấy category Sách Trego
        $sachCategory = Category::where('slug', 'sach-trego')->first();
        
        if (!$sachCategory) {
            $sachCategory = Category::create([
                'name' => 'Sách Trego',
                'slug' => 'sach-trego',
                'description' => 'Sách các thể loại - văn học, kinh tế, kỹ năng sống',
                'is_active' => true,
                'sort_order' => 1
            ]);
        }

        $books = [
            [
                'title' => 'Đắc Nhân Tâm',
                'slug' => 'dac-nhan-tam',
                'description' => 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ứng xử của Dale Carnegie.',
                'short_description' => 'Nghệ thuật giao tiếp và ứng xử trong cuộc sống',
                'isbn' => '978-604-2-24816-8',
                'sku' => 'SACH-DNT-001',
                'price' => 89000,
                'sale_price' => 75000,
                'stock_quantity' => 150,
                'author' => 'Dale Carnegie',
                'translator' => 'Nguyễn Văn Phước',
                'publisher' => 'NXB Tổng Hợp TPHCM',
                'publication_date' => '2020-05-15',
                'language' => 'vi',
                'pages' => 320,
                'format' => 'Bìa mềm',
                'dimensions' => '19 x 13 cm',
                'weight' => 350.5,
                'category_id' => $sachCategory->id,
                'genres' => ['Kỹ năng sống', 'Tâm lý học'],
                'keywords' => ['giao tiếp', 'kỹ năng sống'],
                'images' => ['/images/books/dac-nhan-tam.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => true,
                'new_release' => false
            ],
            [
                'title' => 'Sapiens: Lược Sử Loài Người',
                'slug' => 'sapiens-luoc-su-loai-nguoi',
                'description' => 'Cuốn sách về hành trình tiến hóa của loài người từ 70.000 năm trước.',
                'short_description' => 'Hành trình tiến hóa của loài người',
                'isbn' => '978-604-2-13574-5',
                'sku' => 'SACH-SAP-002',
                'price' => 179000,
                'sale_price' => 149000,
                'stock_quantity' => 89,
                'author' => 'Yuval Noah Harari',
                'translator' => 'Nguyễn Thùy Linh',
                'publisher' => 'NXB Trẻ',
                'publication_date' => '2021-03-10',
                'language' => 'vi',
                'pages' => 512,
                'format' => 'Bìa cứng',
                'dimensions' => '24 x 16 cm',
                'weight' => 720.0,
                'category_id' => $sachCategory->id,
                'genres' => ['Lịch sử', 'Khoa học'],
                'keywords' => ['lịch sử', 'tiến hóa'],
                'images' => ['/images/books/sapiens.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => true,
                'new_release' => false
            ]
        ];

        foreach ($books as $book) {
            ProductsSach::create($book);
        }
    }
}