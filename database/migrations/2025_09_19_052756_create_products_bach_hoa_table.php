<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_bach_hoa', function (Blueprint $table) {
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
            
            // Grocery specific fields
            $table->string('brand');
            $table->string('product_type'); // food, beverage, household, personal_care
            $table->string('category_type'); // snacks, dairy, cleaning, etc.
            
            // Product details
            $table->string('weight_volume')->nullable(); // 500g, 1L, 250ml
            $table->string('packaging_type')->nullable(); // bottle, can, box, bag
            $table->date('expiry_date')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->string('origin_country')->nullable();
            
            // Food specific
            $table->json('ingredients')->nullable();
            $table->json('nutrition_facts')->nullable();
            $table->json('allergen_info')->nullable();
            $table->boolean('organic')->default(false);
            $table->boolean('gluten_free')->default(false);
            $table->boolean('vegan')->default(false);
            $table->boolean('halal')->default(false);
            $table->string('storage_instructions')->nullable();
            
            // Household items
            $table->string('scent')->nullable(); // for cleaning products
            $table->json('usage_instructions')->nullable();
            $table->boolean('antibacterial')->default(false);
            $table->boolean('eco_friendly')->default(false);
            
            // Bulk & Wholesale
            $table->integer('pieces_per_pack')->default(1);
            $table->boolean('bulk_available')->default(false);
            $table->decimal('bulk_price', 10, 2)->nullable();
            $table->integer('min_order_quantity')->default(1);
            
            // Category & Features
            $table->unsignedBigInteger('category_id');
            $table->json('certifications')->nullable(); // FDA, HACCP, etc.
            $table->boolean('refrigerated')->default(false);
            $table->boolean('frozen')->default(false);
            $table->string('temperature_storage')->nullable();
            
            // Media & Status
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft', 'out_of_stock'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('daily_essential')->default(false);
            
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
        Schema::dropIfExists('products_bach_hoa');
    }
};