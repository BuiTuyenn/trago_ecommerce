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
        Schema::create('products_thoi_trang_nu', function (Blueprint $table) {
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
            $table->string('brand'); // Zara, H&M, Chanel, etc.
            $table->string('product_type'); // dress, top, bottom, outerwear, etc.
            $table->string('category_type'); // casual, formal, sportswear, lingerie
            $table->string('style')->nullable(); // bohemian, minimalist, vintage, trendy
            $table->string('season'); // spring, summer, fall, winter, all-season
            
            // Size & Fit
            $table->json('available_sizes'); // ["XS", "S", "M", "L", "XL", "XXL"]
            $table->string('size_guide')->nullable(); // Link to size chart
            $table->string('fit_type')->nullable(); // regular, slim, loose, oversized
            $table->json('size_measurements')->nullable(); // Detailed measurements per size
            
            // Material & Care
            $table->json('materials'); // ["100% Cotton", "Polyester blend"]
            $table->string('primary_material'); // Cotton, Silk, Polyester, etc.
            $table->text('care_instructions')->nullable(); // Washing, drying instructions
            $table->boolean('machine_washable')->default(true);
            $table->boolean('dry_clean_only')->default(false);
            $table->string('fabric_weight')->nullable(); // lightweight, medium, heavy
            
            // Design & Style
            $table->string('color'); // Primary color
            $table->json('available_colors')->nullable(); // All color options
            $table->string('pattern')->nullable(); // solid, stripes, floral, geometric
            $table->string('neckline')->nullable(); // crew, v-neck, scoop, off-shoulder
            $table->string('sleeve_type')->nullable(); // short, long, sleeveless, 3/4
            $table->string('length')->nullable(); // mini, knee-length, midi, maxi
            $table->string('waistline')->nullable(); // high, mid, low, empire
            
            // Specific garment features
            $table->string('closure_type')->nullable(); // zipper, buttons, pullover, tie
            $table->boolean('pockets')->default(false);
            $table->integer('pocket_count')->nullable();
            $table->boolean('lined')->default(false);
            $table->boolean('padded')->default(false);
            $table->json('special_features')->nullable(); // ["adjustable straps", "removable belt"]
            
            // Occasion & Usage
            $table->json('occasions')->nullable(); // ["work", "party", "casual", "wedding"]
            $table->string('dress_code')->nullable(); // casual, business, formal, cocktail
            $table->json('styling_tips')->nullable(); // How to style this item
            
            // Collection & Trend
            $table->string('collection_name')->nullable(); // Spring 2024, Holiday Collection
            $table->string('trend_tag')->nullable(); // trending, classic, limited edition
            $table->boolean('sustainable')->default(false); // Eco-friendly materials
            $table->boolean('ethically_made')->default(false);
            
            // Model & Fit information
            $table->string('model_height')->nullable(); // "175cm"
            $table->string('model_size')->nullable(); // "Size M"
            $table->json('fit_feedback')->nullable(); // Customer fit reviews
            
            // Category & Features
            $table->unsignedBigInteger('category_id');
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('limited_edition')->default(false);
            $table->boolean('exclusive')->default(false);
            
            // International sizing
            $table->json('size_conversion')->nullable(); // US, EU, UK size conversions
            $table->string('target_age_group')->nullable(); // teens, young adults, mature
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable(); // Fashion videos, styling videos
            $table->json('lookbook_images')->nullable(); // Styled outfit photos
            $table->string('size_chart_image')->nullable();
            
            // Shipping & Returns
            $table->decimal('weight_grams', 6, 1)->nullable(); // For shipping calculation
            $table->string('packaging_type')->nullable(); // garment bag, box, poly mailer
            $table->boolean('easy_returns')->default(true);
            $table->integer('return_days')->default(30);
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'sold_out', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('pre_order')->default(false);
            $table->date('available_date')->nullable(); // For pre-orders
            
            // Reviews & Social
            $table->boolean('influencer_favorite')->default(false);
            $table->boolean('editor_pick')->default(false);
            $table->json('styling_hashtags')->nullable(); // Social media hashtags
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['product_type', 'status']);
            $table->index(['category_type', 'status']);
            $table->index(['season', 'status']);
            $table->index(['price', 'status']);
            $table->index(['color', 'status']);
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
        Schema::dropIfExists('products_thoi_trang_nu');
    }
};