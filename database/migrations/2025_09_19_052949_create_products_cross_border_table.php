<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_cross_border', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing (international)
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD'); // USD, EUR, JPY, etc.
            $table->decimal('vnd_price', 12, 2)->nullable(); // Converted VND price
            $table->integer('stock_quantity')->default(0);
            
            // International specific fields
            $table->string('brand');
            $table->string('origin_country'); // Country of origin
            $table->string('supplier_country')->nullable(); // Where we source from
            $table->string('product_type');
            $table->boolean('authentic_guarantee')->default(true);
            $table->string('authenticity_certificate')->nullable();
            
            // Import & Legal
            $table->string('import_license')->nullable();
            $table->json('certifications')->nullable(); // FDA, CE, etc.
            $table->boolean('customs_cleared')->default(false);
            $table->string('hs_code')->nullable(); // Harmonized System code
            $table->decimal('import_tax_rate', 5, 2)->nullable(); // %
            
            // Shipping & Logistics
            $table->string('shipping_method')->default('air'); // air, sea, express
            $table->integer('estimated_delivery_days')->default(14);
            $table->decimal('shipping_cost', 8, 2)->nullable();
            $table->boolean('free_shipping')->default(false);
            $table->decimal('min_order_for_free_shipping', 10, 2)->nullable();
            $table->string('warehouse_location')->nullable(); // Overseas warehouse
            
            // Product details
            $table->string('dimensions')->nullable();
            $table->decimal('weight', 8, 2)->nullable(); // kg
            $table->string('package_type')->nullable();
            $table->json('package_contents')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->json('languages_supported')->nullable(); // Product language support
            
            // Quality & Standards
            $table->string('quality_standard')->nullable(); // FDA, CE, JIS, etc.
            $table->json('safety_warnings')->nullable();
            $table->boolean('age_restricted')->default(false);
            $table->string('minimum_age')->nullable();
            $table->json('restricted_countries')->nullable(); // Countries we can't ship to
            
            // Warranty & Support
            $table->boolean('international_warranty')->default(false);
            $table->integer('warranty_months')->nullable();
            $table->string('warranty_provider')->nullable(); // manufacturer, importer
            $table->boolean('local_service_available')->default(false);
            $table->text('return_policy')->nullable();
            
            // Category & Features
            $table->unsignedBigInteger('category_id');
            $table->json('features')->nullable();
            $table->boolean('limited_edition')->default(false);
            $table->boolean('seasonal_item')->default(false);
            $table->date('available_until')->nullable(); // Limited time availability
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('product_brochure')->nullable();
            $table->json('unboxing_videos')->nullable();
            
            // Reviews & Social Proof
            $table->decimal('international_rating', 3, 2)->nullable(); // Average rating abroad
            $table->integer('international_review_count')->default(0);
            $table->json('featured_reviews')->nullable();
            $table->boolean('influencer_recommended')->default(false);
            
            // Status
            $table->enum('status', ['active', 'inactive', 'pre_order', 'out_of_stock', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('trending_globally')->default(false);
            $table->boolean('bestseller_abroad')->default(false);
            $table->boolean('new_to_vietnam')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['origin_country', 'status']);
            $table->index(['currency', 'status']);
            $table->index(['estimated_delivery_days', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_cross_border');
    }
};