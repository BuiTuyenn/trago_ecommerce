<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [];
        
        // Tạo 20 sản phẩm để test pagination
        for ($i = 1; $i <= 20; $i++) {
            $books[] = [
                'title' => "Test Book $i - Sách Test Pagination",
                'author' => "Tác giả $i",
                'publisher' => 'NXB Test',
                'isbn' => '978604114150' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'price' => rand(100000, 500000),
                'sale_price' => rand(80000, 400000),
                'stock_quantity' => rand(10, 100),
                'description' => "Đây là mô tả chi tiết cho cuốn sách test số $i. Cuốn sách này được tạo để test pagination.",
                'short_description' => "Sách test số $i",
                'category_id' => 1, // Default category ID
                'language' => $i % 2 == 0 ? 'English' : 'Vietnamese',
                'pages' => rand(200, 600),
                'format' => $i % 3 == 0 ? 'Hardcover' : 'Paperback',
                'weight' => rand(3, 8) / 10,
                'dimensions' => '20x13x2',
                'images' => json_encode(["books/test-book-$i.jpg"]),
                'featured' => $i <= 5,
                'bestseller' => $i <= 8,
                'status' => 'active',
                'slug' => "test-book-$i",
                'sku' => "BOOK-TEST-" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products_sach')->insert($books);
        
        $this->command->info('Added ' . count($books) . ' test books to products_sach table');
    }
}
