<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_thoi_trang_nam', function (Blueprint $table) {
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
            
            // Fashion specific fields
            $table->string('brand');
            $table->string('product_type'); // shirt, pants, jacket, etc.
            $table->string('category_type'); // casual, formal, sportswear
            $table->string('style')->nullable(); // classic, modern, trendy
            $table->string('season'); // spring, summer, fall, winter
            
            // Size & Fit
            $table->json('available_sizes'); // ["S", "M", "L", "XL", "XXL"]
            $table->string('fit_type')->nullable(); // regular, slim, loose
            $table->string('size_guide')->nullable();
            
            // Material & Design
            $table->json('materials');
            $table->string('primary_material');
            $table->text('care_instructions')->nullable();
            $table->boolean('machine_washable')->default(true);
            $table->string('color');
            $table->json('available_colors')->nullable();
            $table->string('pattern')->nullable(); // solid, stripes, checks
            
            // Garment details
            $table->string('neckline')->nullable(); // crew, v-neck, polo
            $table->string('sleeve_type')->nullable(); // short, long, sleeveless
            $table->string('closure_type')->nullable(); // buttons, zip, pullover
            $table->boolean('pockets')->default(false);
            $table->json('special_features')->nullable();
            
            // Category & Usage
            $table->unsignedBigInteger('category_id');
            $table->json('occasions')->nullable(); // work, casual, formal
            $table->string('dress_code')->nullable();
            
            // Media & Status
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_thoi_trang_nam');
    }
};