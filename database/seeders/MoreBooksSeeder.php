<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductsSach;
use App\Models\Category;

class MoreBooksSeeder extends Seeder
{
    public function run()
    {
        $sachCategory = Category::where('slug', 'sach-trego')->first();

        $moreBooks = [
            [
                'title' => 'Atomic Habits - Thay Đổi Tí Hon Hiệu Quả Bất Ngờ',
                'slug' => 'atomic-habits-thay-doi-ti-hon',
                'description' => 'James Clear tiết lộ những chiến lược thực tế để hình thành thói quen tốt.',
                'short_description' => 'Nghệ thuật xây dựng thói quen tích cực',
                'isbn' => '978-604-2-25918-8',
                'sku' => 'SACH-ATH-003',
                'price' => 139000,
                'sale_price' => 119000,
                'stock_quantity' => 200,
                'author' => 'James Clear',
                'translator' => 'Nguyễn Hương Giang',
                'publisher' => 'NXB Thế Giới',
                'publication_date' => '2021-11-25',
                'language' => 'vi',
                'pages' => 384,
                'format' => 'Bìa mềm',
                'dimensions' => '20.5 x 14 cm',
                'weight' => 420.0,
                'category_id' => $sachCategory->id,
                'genres' => ['Kỹ năng sống', 'Tự phát triển'],
                'keywords' => ['thói quen', 'tự phát triển'],
                'images' => ['/images/books/atomic-habits.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => false,
                'new_release' => true
            ],
            [
                'title' => 'Nhà Giả Kim',
                'slug' => 'nha-gia-kim',
                'description' => 'Tiểu thuyết nổi tiếng của Paulo Coelho về hành trình tìm kiếm kho báu.',
                'short_description' => 'Hành trình tìm kiếm ước mơ và ý nghĩa cuộc sống',
                'isbn' => '978-604-2-09876-3',
                'sku' => 'SACH-NGC-004',
                'price' => 79000,
                'sale_price' => 65000,
                'stock_quantity' => 120,
                'author' => 'Paulo Coelho',
                'translator' => 'Lê Chu Cầu',
                'publisher' => 'NXB Hội Nhà Văn',
                'publication_date' => '2019-12-05',
                'language' => 'vi',
                'pages' => 227,
                'format' => 'Bìa mềm',
                'dimensions' => '19 x 13 cm',
                'weight' => 250.0,
                'category_id' => $sachCategory->id,
                'genres' => ['Tiểu thuyết', 'Triết học'],
                'keywords' => ['ước mơ', 'hành trình'],
                'images' => ['/images/books/nha-gia-kim.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => true,
                'new_release' => false
            ],
            [
                'title' => 'Tuổi Trẻ Đáng Giá Bao Nhiêu',
                'slug' => 'tuoi-tre-dang-gia-bao-nhieu',
                'description' => 'Rosie Nguyễn chia sẻ những trải nghiệm về tuổi trẻ và cách sống ý nghĩa.',
                'short_description' => 'Những suy ngẫm về tuổi trẻ',
                'isbn' => '978-604-2-22567-9',
                'sku' => 'SACH-TTD-005',
                'price' => 89000,
                'sale_price' => null,
                'stock_quantity' => 180,
                'author' => 'Rosie Nguyễn',
                'translator' => null,
                'publisher' => 'NXB Hồng Đức',
                'publication_date' => '2022-01-15',
                'language' => 'vi',
                'pages' => 296,
                'format' => 'Bìa mềm',
                'dimensions' => '20 x 14 cm',
                'weight' => 340.0,
                'category_id' => $sachCategory->id,
                'genres' => ['Kỹ năng sống', 'Tuổi trẻ'],
                'keywords' => ['tuổi trẻ', 'ước mơ'],
                'images' => ['/images/books/tuoi-tre-dang-gia.jpg'],
                'status' => 'active',
                'featured' => false,
                'bestseller' => true,
                'new_release' => true
            ],
            [
                'title' => 'Think and Grow Rich - 13 Nguyên Tắc Nghĩ Giàu Làm Giàu',
                'slug' => 'think-and-grow-rich',
                'description' => 'Napoleon Hill rút ra 13 nguyên tắc thành công từ 500 triệu phú.',
                'short_description' => '13 nguyên tắc thành công',
                'isbn' => '978-604-2-15432-7',
                'sku' => 'SACH-TGR-006',
                'price' => 159000,
                'sale_price' => 129000,
                'stock_quantity' => 95,
                'author' => 'Napoleon Hill',
                'translator' => 'Nguyễn Minh Đức',
                'publisher' => 'NXB Lao Động',
                'publication_date' => '2021-02-18',
                'language' => 'vi',
                'pages' => 448,
                'format' => 'Bìa cứng',
                'dimensions' => '24 x 16 cm',
                'weight' => 680.0,
                'category_id' => $sachCategory->id,
                'genres' => ['Kinh doanh', 'Tài chính'],
                'keywords' => ['làm giàu', 'kinh doanh'],
                'images' => ['/images/books/think-grow-rich.jpg'],
                'status' => 'active',
                'featured' => true,
                'bestseller' => false,
                'new_release' => false
            ]
        ];

        foreach ($moreBooks as $book) {
            ProductsSach::create($book);
        }
    }
}