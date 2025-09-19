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
        Schema::create('products_lam_dep', function (Blueprint $table) {
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
            
            // Beauty product specific fields
            $table->string('brand'); // L'Oreal, Maybelline, MAC, etc.
            $table->string('product_type'); // skincare, makeup, fragrance, hair_care, tools
            $table->string('category_type'); // face, eyes, lips, body, hair
            $table->string('target_gender')->default('female'); // male, female, unisex
            
            // Product characteristics
            $table->json('skin_types')->nullable(); // ["oily", "dry", "combination", "sensitive"]
            $table->string('skin_concern')->nullable(); // acne, aging, dryness, sensitivity
            $table->string('hair_type')->nullable(); // oily, dry, normal, damaged, colored
            $table->string('coverage')->nullable(); // light, medium, full (for makeup)
            $table->string('finish')->nullable(); // matte, dewy, satin, glossy
            $table->string('shade')->nullable(); // Color/shade name
            $table->json('available_shades')->nullable(); // All available shades
            
            // Formulation & Ingredients
            $table->json('key_ingredients')->nullable(); // Main active ingredients
            $table->json('full_ingredients')->nullable(); // Complete INCI list
            $table->boolean('paraben_free')->default(false);
            $table->boolean('sulfate_free')->default(false);
            $table->boolean('fragrance_free')->default(false);
            $table->boolean('alcohol_free')->default(false);
            $table->boolean('cruelty_free')->default(false);
            $table->boolean('vegan')->default(false);
            $table->boolean('organic')->default(false);
            $table->boolean('natural')->default(false);
            $table->string('spf_level')->nullable(); // SPF 15, SPF 30, SPF 50
            
            // Product details
            $table->string('volume')->nullable(); // 30ml, 50g, 100ml
            $table->string('texture')->nullable(); // cream, gel, liquid, powder, serum
            $table->string('scent')->nullable(); // fragrance description
            $table->date('expiry_date')->nullable(); // Product expiry
            $table->integer('shelf_life_months')->nullable(); // Shelf life after opening
            $table->string('origin_country')->nullable(); // Manufacturing country
            
            // Application & Usage
            $table->text('how_to_use')->nullable(); // Detailed usage instructions
            $table->string('application_method')->nullable(); // hands, brush, sponge, applicator
            $table->json('suitable_time')->nullable(); // ["morning", "evening", "anytime"]
            $table->string('recommended_age')->nullable(); // 18+, teens, all ages
            $table->integer('application_frequency')->nullable(); // times per day/week
            
            // Certifications & Testing
            $table->json('certifications')->nullable(); // ["FDA", "CE", "HALAL", "KOSHER"]
            $table->json('awards')->nullable(); // Beauty awards received
            $table->boolean('dermatologist_tested')->default(false);
            $table->boolean('ophthalmologist_tested')->default(false); // for eye products
            $table->boolean('hypoallergenic')->default(false);
            $table->boolean('non_comedogenic')->default(false);
            $table->boolean('patch_tested')->default(false);
            
            // Target & Benefits
            $table->json('benefits')->nullable(); // ["anti-aging", "moisturizing", "brightening"]
            $table->json('concerns_addressed')->nullable(); // ["acne", "wrinkles", "dark_spots"]
            $table->string('season_suitable')->nullable(); // summer, winter, all_seasons
            $table->json('suitable_skin_tones')->nullable(); // for makeup products
            
            // Package & Set info
            $table->boolean('is_set')->default(false);
            $table->json('set_includes')->nullable(); // If it's a beauty set
            $table->string('packaging_type')->nullable(); // tube, bottle, compact, pump
            $table->boolean('refillable')->default(false);
            $table->boolean('travel_size')->default(false);
            $table->string('applicator_included')->nullable(); // brush, sponge, wand
            
            // Professional & Special use
            $table->boolean('professional_use')->default(false);
            $table->string('salon_brand')->nullable();
            $table->boolean('waterproof')->default(false); // for makeup
            $table->boolean('long_wearing')->default(false);
            $table->integer('wear_time_hours')->nullable(); // 8 hours, 12 hours
            
            // Category & Features
            $table->unsignedBigInteger('category_id');
            $table->boolean('trending')->default(false);
            $table->boolean('viral')->default(false); // trending on social media
            $table->json('makeup_look_suitable')->nullable(); // ["natural", "glam", "bold"]
            
            // Media & Content
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->json('tutorials')->nullable(); // Tutorial video links
            $table->json('before_after_images')->nullable(); // Before/after photos
            $table->string('ingredient_list_pdf')->nullable();
            $table->json('shade_swatches')->nullable(); // Swatch images
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'limited_edition', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_launch')->default(false);
            $table->boolean('limited_edition')->default(false);
            $table->boolean('exclusive')->default(false);
            
            // Reviews & Social proof
            $table->boolean('editor_choice')->default(false);
            $table->boolean('customer_favorite')->default(false);
            $table->boolean('influencer_approved')->default(false);
            $table->json('featured_in_media')->nullable(); // Magazine features
            
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
            $table->index(['target_gender', 'status']);
            $table->index(['shade', 'status']);
            $table->index(['expiry_date', 'status']);
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
        Schema::dropIfExists('products_lam_dep');
    }
};