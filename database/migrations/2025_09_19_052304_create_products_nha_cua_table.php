<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_nha_cua', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Home product specific fields
            $table->string('brand'); // Thương hiệu
            $table->string('product_type'); // Furniture, Decor, Kitchen, Bathroom, etc.
            $table->string('room_type'); // Living room, bedroom, kitchen, bathroom, etc.
            $table->string('style')->nullable(); // Modern, vintage, minimalist, etc.
            
            // Physical specifications
            $table->string('dimensions'); // Kích thước (DxRxC cm)
            $table->decimal('weight', 8, 2)->nullable(); // Cân nặng (kg)
            $table->string('color'); // Màu sắc chính
            $table->json('available_colors')->nullable(); // Các màu có sẵn
            $table->json('materials')->nullable(); // Chất liệu (wood, metal, fabric, etc.)
            $table->string('primary_material'); // Chất liệu chính
            
            // Furniture specific
            $table->integer('seating_capacity')->nullable(); // Số chỗ ngồi (sofa, dining table)
            $table->string('assembly_required')->default('yes'); // yes, no, partial
            $table->integer('assembly_time_minutes')->nullable(); // Thời gian lắp ráp
            $table->json('assembly_tools_needed')->nullable(); // Công cụ cần thiết
            $table->boolean('includes_hardware')->default(true); // Bao gồm ốc vít
            
            // Design & Features
            $table->string('finish')->nullable(); // Satin, gloss, matte
            $table->json('features')->nullable(); // Storage, adjustable, foldable, etc.
            $table->boolean('adjustable')->default(false); // Có thể điều chỉnh
            $table->boolean('foldable')->default(false); // Có thể gấp gọn
            $table->boolean('stackable')->default(false); // Có thể xếp chồng
            $table->string('shape')->nullable(); // Round, square, rectangular, etc.
            
            // Care & Maintenance
            $table->text('care_instructions')->nullable(); // Hướng dẫn chăm sóc
            $table->boolean('water_resistant')->default(false); // Chống nước
            $table->boolean('stain_resistant')->default(false); // Chống bẩn
            $table->boolean('fade_resistant')->default(false); // Chống phai màu
            $table->string('cleaning_method')->nullable(); // Hand wash, machine wash, dry clean
            
            // Safety & Certifications
            $table->json('safety_certifications')->nullable(); // GREENGUARD, FSC, etc.
            $table->boolean('child_safe')->default(false); // An toàn cho trẻ em
            $table->boolean('pet_friendly')->default(false); // Thân thiện với thú cưng
            $table->boolean('eco_friendly')->default(false); // Thân thiện môi trường
            $table->string('origin_country')->nullable(); // Xuất xứ
            
            // Category & Usage
            $table->unsignedBigInteger('category_id');
            $table->string('usage_type')->nullable(); // Indoor, outdoor, both
            $table->string('season_suitable')->nullable(); // All seasons, summer, winter
            $table->json('occasions')->nullable(); // Daily use, parties, holidays
            
            // Package & Shipping
            $table->string('package_dimensions')->nullable(); // Kích thước đóng gói
            $table->decimal('package_weight', 8, 2)->nullable(); // Trọng lượng đóng gói
            $table->integer('packages_count')->default(1); // Số kiện hàng
            $table->boolean('white_glove_delivery')->default(false); // Giao hàng tận nơi
            $table->boolean('installation_available')->default(false); // Có dịch vụ lắp đặt
            $table->decimal('installation_fee', 8, 2)->nullable(); // Phí lắp đặt
            
            // Warranty & Support
            $table->integer('warranty_years')->default(1); // Bảo hành (năm)
            $table->text('warranty_terms')->nullable(); // Điều khoản bảo hành
            $table->boolean('replacement_parts_available')->default(false); // Có phụ tùng thay thế
            
            // Collection & Set info
            $table->string('collection_name')->nullable(); // Tên bộ sưu tập
            $table->boolean('part_of_set')->default(false); // Thuộc bộ sản phẩm
            $table->json('matching_items')->nullable(); // Sản phẩm cùng bộ
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('assembly_manual')->nullable(); // Hướng dẫn lắp ráp PDF
            $table->json('room_inspirations')->nullable(); // Ảnh phối cảnh phòng
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'custom_order', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('custom_made')->default(false); // Làm theo yêu cầu
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['product_type', 'status']);
            $table->index(['room_type', 'status']);
            $table->index(['style', 'status']);
            $table->index(['primary_material', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_nha_cua');
    }
};