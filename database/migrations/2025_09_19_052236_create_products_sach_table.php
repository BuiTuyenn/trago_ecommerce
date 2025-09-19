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
        Schema::create('products_sach', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('title'); // Tên sách
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('isbn')->unique()->nullable(); // Mã ISBN
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Book specific fields
            $table->string('author'); // Tác giả
            $table->string('translator')->nullable(); // Người dịch
            $table->string('publisher'); // Nhà xuất bản
            $table->date('publication_date')->nullable(); // Ngày xuất bản
            $table->string('language')->default('vi'); // Ngôn ngữ
            $table->integer('pages')->nullable(); // Số trang
            $table->string('format')->nullable(); // Bìa cứng/mềm, ebook, audiobook
            $table->string('dimensions')->nullable(); // Kích thước
            $table->decimal('weight', 8, 2)->nullable(); // Cân nặng (gram)
            
            // Category & Genre
            $table->unsignedBigInteger('category_id'); // Danh mục chính
            $table->json('genres')->nullable(); // Thể loại phụ (kinh dị, lãng mạn, etc.)
            $table->string('series')->nullable(); // Bộ sách
            $table->integer('volume')->nullable(); // Tập thứ
            
            // Content rating
            $table->string('age_rating')->nullable(); // 18+, 16+, etc.
            $table->json('keywords')->nullable(); // Từ khóa tìm kiếm
            
            // Media
            $table->json('images')->nullable();
            $table->string('preview_pdf')->nullable(); // Link preview PDF
            $table->string('audio_sample')->nullable(); // Sample audio cho audiobook
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'out_of_print'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_release')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['author', 'status']);
            $table->index(['publisher', 'status']);
            $table->index(['publication_date', 'status']);
            $table->fullText(['title', 'author', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_sach');
    }
};