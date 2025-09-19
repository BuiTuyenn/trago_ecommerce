<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create main book category
        $bookCategory = Category::create([
            'name' => 'Sách Trego',
            'slug' => 'sach-trego',
            'description' => 'Khám phá thế giới tri thức với bộ sưu tập sách đa dạng từ Trego - từ kinh doanh, kỹ năng sống đến văn học và công nghệ.',
            'image' => '/images/categories/books.jpg',
            'is_active' => true,
            'sort_order' => 1,
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sub-categories
        $subCategories = [
            [
                'name' => 'Sách Kinh Doanh',
                'slug' => 'sach-kinh-doanh',
                'description' => 'Sách về kinh doanh, khởi nghiệp và quản lý',
                'parent_id' => $bookCategory->id,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sách Kỹ Năng Sống',
                'slug' => 'sach-ky-nang-song',
                'description' => 'Phát triển bản thân và kỹ năng mềm',
                'parent_id' => $bookCategory->id,
                'sort_order' => 2,
            ],
            [
                'name' => 'Sách Văn Học',
                'slug' => 'sach-van-hoc',
                'description' => 'Tiểu thuyết, thơ ca và văn học kinh điển',
                'parent_id' => $bookCategory->id,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sách Công Nghệ',
                'slug' => 'sach-cong-nghe',
                'description' => 'Lập trình, AI và công nghệ số',
                'parent_id' => $bookCategory->id,
                'sort_order' => 4,
            ],
        ];

        foreach ($subCategories as $subCat) {
            Category::create(array_merge($subCat, [
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Get created categories
        $businessCategory = Category::where('slug', 'sach-kinh-doanh')->first();
        $skillsCategory = Category::where('slug', 'sach-ky-nang-song')->first();
        $literatureCategory = Category::where('slug', 'sach-van-hoc')->first();
        $techCategory = Category::where('slug', 'sach-cong-nghe')->first();

        // Create sample products for each category
        $products = [
            // Business Books
            [
                'name' => 'Khởi Nghiệp Lean - The Lean Startup',
                'slug' => 'khoi-nghiep-lean',
                'short_description' => 'Phương pháp khởi nghiệp hiệu quả với chi phí tối thiểu',
                'description' => 'Cuốn sách hướng dẫn cách xây dựng startup thành công với phương pháp Lean, giúp tiết kiệm thời gian và chi phí.',
                'price' => 299000,
                'sale_price' => 249000,
                'sku' => 'BOOK-LS-001',
                'stock_quantity' => 50,
                'category_id' => $businessCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/lean-startup.jpg']),
            ],
            [
                'name' => 'Tư Duy Nhanh Và Chậm - Thinking Fast And Slow',
                'slug' => 'tu-duy-nhanh-va-cham',
                'short_description' => 'Khám phá cách thức hoạt động của bộ não con người',
                'description' => 'Daniel Kahneman chia sẻ những hiểu biết sâu sắc về tâm lý học và kinh tế học hành vi.',
                'price' => 350000,
                'sale_price' => 315000,
                'sku' => 'BOOK-TF-002',
                'stock_quantity' => 30,
                'category_id' => $businessCategory->id,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode(['/images/products/thinking-fast-slow.jpg']),
            ],
            [
                'name' => 'Từ Tốt Đến Vĩ Đại - Good To Great',
                'slug' => 'tu-tot-den-vi-dai',
                'short_description' => 'Bí quyết chuyển đổi từ công ty tốt thành công ty vĩ đại',
                'description' => 'Jim Collins nghiên cứu và chia sẻ những yếu tố giúp các công ty chuyển đổi thành công.',
                'price' => 280000,
                'sale_price' => null,
                'sku' => 'BOOK-GTG-003',
                'stock_quantity' => 40,
                'category_id' => $businessCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/good-to-great.jpg']),
            ],

            // Skills Books
            [
                'name' => 'Đắc Nhân Tâm - How To Win Friends',
                'slug' => 'dac-nhan-tam',
                'short_description' => 'Nghệ thuật giao tiếp và ứng xử với mọi người',
                'description' => 'Cuốn sách kinh điển về kỹ năng giao tiếp và xây dựng mối quan hệ của Dale Carnegie.',
                'price' => 180000,
                'sale_price' => 149000,
                'sku' => 'BOOK-DNT-004',
                'stock_quantity' => 100,
                'category_id' => $skillsCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/dac-nhan-tam.jpg']),
            ],
            [
                'name' => 'Atomic Habits - Thói Quen Tốt',
                'slug' => 'atomic-habits',
                'short_description' => 'Xây dựng thói quen tốt và loại bỏ thói quen xấu',
                'description' => 'James Clear hướng dẫn cách tạo lập và duy trì những thói quen tích cực trong cuộc sống.',
                'price' => 320000,
                'sale_price' => 288000,
                'sku' => 'BOOK-AH-005',
                'stock_quantity' => 75,
                'category_id' => $skillsCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/atomic-habits.jpg']),
            ],
            [
                'name' => 'Mindset - Tư Duy Phát Triển',
                'slug' => 'mindset-tu-duy-phat-trien',
                'short_description' => 'Sức mạnh của tư duy trong thành công',
                'description' => 'Carol Dweck khám phá tầm quan trọng của tư duy phát triển so với tư duy cố định.',
                'price' => 250000,
                'sale_price' => 225000,
                'sku' => 'BOOK-MS-006',
                'stock_quantity' => 60,
                'category_id' => $skillsCategory->id,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode(['/images/products/mindset.jpg']),
            ],

            // Literature Books
            [
                'name' => 'Nhà Giả Kim - The Alchemist',
                'slug' => 'nha-gia-kim',
                'short_description' => 'Hành trình tìm kiếm kho báu và ý nghĩa cuộc sống',
                'description' => 'Tiểu thuyết nổi tiếng của Paulo Coelho về hành trình khám phá bản thân và theo đuổi ước mơ.',
                'price' => 120000,
                'sale_price' => 99000,
                'sku' => 'BOOK-NGC-007',
                'stock_quantity' => 80,
                'category_id' => $literatureCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/nha-gia-kim.jpg']),
            ],
            [
                'name' => 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh',
                'slug' => 'toi-thay-hoa-vang-tren-co-xanh',
                'short_description' => 'Câu chuyện tuổi thơ đầy cảm xúc',
                'description' => 'Tác phẩm của Nguyễn Nhật Ánh về tuổi thơ và những kỷ niệm đẹp ở vùng quê.',
                'price' => 150000,
                'sale_price' => null,
                'sku' => 'BOOK-TTHV-008',
                'stock_quantity' => 45,
                'category_id' => $literatureCategory->id,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode(['/images/products/toi-thay-hoa-vang.jpg']),
            ],

            // Technology Books
            [
                'name' => 'Clean Code - Mã Nguồn Sạch',
                'slug' => 'clean-code',
                'short_description' => 'Nghệ thuật viết code chuyên nghiệp',
                'description' => 'Robert C. Martin hướng dẫn cách viết code sạch, dễ đọc và dễ bảo trì.',
                'price' => 450000,
                'sale_price' => 405000,
                'sku' => 'BOOK-CC-009',
                'stock_quantity' => 35,
                'category_id' => $techCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/clean-code.jpg']),
            ],
            [
                'name' => 'Artificial Intelligence - A Guide',
                'slug' => 'artificial-intelligence-guide',
                'short_description' => 'Hướng dẫn toàn diện về trí tuệ nhân tạo',
                'description' => 'Cẩm nang về AI, machine learning và ứng dụng trong thực tế.',
                'price' => 580000,
                'sale_price' => 522000,
                'sku' => 'BOOK-AI-010',
                'stock_quantity' => 25,
                'category_id' => $techCategory->id,
                'status' => 'active',
                'featured' => true,
                'images' => json_encode(['/images/products/ai-guide.jpg']),
            ],
            [
                'name' => 'JavaScript: The Definitive Guide',
                'slug' => 'javascript-definitive-guide',
                'short_description' => 'Cẩm nang JavaScript hoàn chỉnh',
                'description' => 'David Flanagan cung cấp hướng dẫn chi tiết về JavaScript từ cơ bản đến nâng cao.',
                'price' => 650000,
                'sale_price' => null,
                'sku' => 'BOOK-JS-011',
                'stock_quantity' => 20,
                'category_id' => $techCategory->id,
                'status' => 'active',
                'featured' => false,
                'images' => json_encode(['/images/products/javascript-guide.jpg']),
            ],
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('Book category and products seeded successfully!');
    }
}