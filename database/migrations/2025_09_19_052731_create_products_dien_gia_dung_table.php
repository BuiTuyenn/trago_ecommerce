<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_dien_gia_dung', function (Blueprint $table) {
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
            
            // Appliance specific fields
            $table->string('brand');
            $table->string('model')->nullable();
            $table->string('appliance_type'); // refrigerator, washing_machine, microwave, etc.
            $table->string('power_consumption')->nullable(); // Watts
            $table->string('voltage')->nullable(); // 220V, 110V
            $table->string('frequency')->nullable(); // 50Hz, 60Hz
            $table->string('dimensions'); // WxDxH
            $table->decimal('weight', 8, 2)->nullable(); // kg
            $table->string('color');
            $table->json('available_colors')->nullable();
            $table->string('energy_rating')->nullable(); // A++, A+, etc.
            $table->integer('warranty_months')->default(12);
            $table->string('origin_country')->nullable();
            
            // Features
            $table->json('features')->nullable();
            $table->boolean('smart_features')->default(false);
            $table->boolean('wifi_enabled')->default(false);
            $table->boolean('energy_efficient')->default(false);
            $table->json('included_accessories')->nullable();
            
            // Installation & Service
            $table->boolean('requires_installation')->default(false);
            $table->decimal('installation_fee', 8, 2)->nullable();
            $table->text('installation_notes')->nullable();
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->string('user_manual')->nullable();
            
            // Status
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
            $table->index(['appliance_type', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_dien_gia_dung');
    }
};