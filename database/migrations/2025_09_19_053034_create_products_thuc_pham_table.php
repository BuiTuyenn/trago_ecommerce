<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_thuc_pham', function (Blueprint $table) {
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
            
            // Food specific fields
            $table->string('brand');
            $table->string('product_type'); // snacks, beverages, canned, frozen, fresh
            $table->string('category_type'); // sweet, salty, spicy, healthy
            $table->string('weight_volume'); // 500g, 1L, 250ml
            $table->string('packaging_type'); // bottle, can, box, bag
            $table->date('expiry_date')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->string('origin_country');
            
            // Nutritional info
            $table->json('ingredients')->nullable();
            $table->json('nutrition_facts')->nullable(); // calories, protein, etc.
            $table->json('allergen_info')->nullable();
            $table->boolean('organic')->default(false);
            $table->boolean('gluten_free')->default(false);
            $table->boolean('vegan')->default(false);
            $table->boolean('halal')->default(false);
            $table->boolean('kosher')->default(false);
            $table->string('storage_temp')->nullable(); // room_temp, refrigerated, frozen
            $table->text('storage_instructions')->nullable();
            
            // Food safety & quality
            $table->json('certifications')->nullable(); // FDA, HACCP, ISO
            $table->string('quality_grade')->nullable(); // premium, standard, economy
            $table->boolean('preservative_free')->default(false);
            $table->boolean('artificial_color_free')->default(false);
            $table->string('shelf_life')->nullable(); // months
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('seasonal')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['product_type', 'status']);
            $table->index(['expiry_date', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_thuc_pham');
    }
};