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
        Schema::create('products_the_thao', function (Blueprint $table) {
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
            
            // Sports product specific fields
            $table->string('brand'); // Nike, Adidas, Puma, Under Armour
            $table->string('product_type'); // equipment, apparel, footwear, accessories
            $table->string('sport_category'); // football, basketball, running, gym, swimming
            $table->string('target_gender')->default('unisex'); // male, female, unisex, kids
            $table->string('skill_level')->nullable(); // beginner, intermediate, advanced, professional
            
            // Size & Fit (for apparel/footwear)
            $table->json('available_sizes')->nullable(); // ["XS", "S", "M", "L"] or shoe sizes
            $table->string('size_guide')->nullable(); // Link to size chart
            $table->string('fit_type')->nullable(); // regular, slim, loose, compression
            $table->json('size_measurements')->nullable(); // Detailed measurements
            
            // Material & Construction
            $table->json('materials')->nullable(); // ["Polyester 85%", "Elastane 15%"]
            $table->string('primary_material')->nullable(); // Polyester, Cotton, Synthetic
            $table->boolean('water_resistant')->default(false);
            $table->boolean('breathable')->default(false);
            $table->boolean('moisture_wicking')->default(false);
            $table->boolean('anti_odor')->default(false);
            $table->boolean('uv_protection')->default(false);
            $table->boolean('quick_dry')->default(false);
            
            // Performance attributes
            $table->string('performance_level')->nullable(); // training, competition, casual
            $table->json('technologies')->nullable(); // ["Nike Dri-FIT", "Adidas Climacool"]
            $table->string('support_type')->nullable(); // high, medium, low, maximum
            $table->string('terrain_type')->nullable(); // indoor, outdoor, all-terrain
            $table->string('weather_suitable')->nullable(); // hot, cold, wet, dry, all-weather
            
            // Equipment specific
            $table->string('equipment_category')->nullable(); // ball, racket, weights, protective
            $table->string('regulation_standard')->nullable(); // FIFA approved, NBA official
            $table->boolean('professional_grade')->default(false);
            $table->string('age_group')->nullable(); // kids, youth, adult, senior
            $table->string('weight')->nullable(); // Product weight
            $table->string('dimensions')->nullable(); // Product dimensions
            
            // Apparel specific
            $table->string('clothing_type')->nullable(); // jersey, shorts, jacket, pants
            $table->string('sleeve_length')->nullable(); // short, long, sleeveless, 3/4
            $table->string('neckline')->nullable(); // crew, v-neck, mock, polo
            $table->boolean('compression')->default(false);
            $table->integer('compression_level')->nullable(); // 1-5 scale
            $table->string('hem_type')->nullable(); // straight, curved, split
            
            // Footwear specific
            $table->string('shoe_type')->nullable(); // running, basketball, football, cross-training
            $table->string('closure_type')->nullable(); // lace-up, velcro, slip-on
            $table->string('heel_type')->nullable(); // flat, raised, platform
            $table->string('sole_material')->nullable(); // rubber, foam, carbon fiber
            $table->boolean('cleated')->default(false);
            $table->string('cleat_type')->nullable(); // molded, detachable, turf
            $table->string('cushioning_type')->nullable(); // air, gel, foam, spring
            
            // Color & Design
            $table->string('color'); // Primary color
            $table->json('available_colors')->nullable(); // All color options
            $table->string('pattern')->nullable(); // solid, stripes, camo, abstract
            $table->string('team_colors')->nullable(); // If team merchandise
            $table->boolean('reflective_elements')->default(false);
            
            // Category & Usage
            $table->unsignedBigInteger('category_id');
            $table->json('suitable_activities')->nullable(); // Multiple sports/activities
            $table->string('season_suitable')->nullable(); // spring, summer, fall, winter
            $table->json('training_focus')->nullable(); // ["strength", "cardio", "flexibility"]
            
            // Care & Maintenance
            $table->text('care_instructions')->nullable();
            $table->boolean('machine_washable')->default(true);
            $table->string('recommended_storage')->nullable();
            $table->boolean('requires_maintenance')->default(false);
            
            // Safety & Performance
            $table->json('safety_features')->nullable(); // ["reflective strips", "padding"]
            $table->boolean('impact_resistant')->default(false);
            $table->string('protection_level')->nullable(); // For protective gear
            $table->json('certifications')->nullable(); // Safety/quality certifications
            
            // Team & Customization
            $table->boolean('customizable')->default(false);
            $table->json('customization_options')->nullable(); // ["name", "number", "logo"]
            $table->string('team_edition')->nullable(); // Official team merchandise
            $table->boolean('licensed_product')->default(false);
            $table->string('league_official')->nullable(); // NFL, NBA, FIFA official
            
            // Athlete & Endorsement
            $table->string('athlete_signature')->nullable(); // Signature products
            $table->boolean('pro_athlete_worn')->default(false);
            $table->json('endorsements')->nullable(); // Athlete endorsements
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->json('action_shots')->nullable(); // In-action photos/videos
            $table->string('size_guide_pdf')->nullable();
            $table->json('training_videos')->nullable(); // How-to-use videos
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'limited_edition', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('limited_edition')->default(false);
            $table->boolean('athlete_endorsed')->default(false);
            $table->boolean('performance_tested')->default(false);
            
            // Awards & Recognition
            $table->string('award_won')->nullable(); // Product awards
            $table->boolean('coach_recommended')->default(false);
            $table->json('media_reviews')->nullable(); // Professional reviews
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['product_type', 'status']);
            $table->index(['sport_category', 'status']);
            $table->index(['target_gender', 'status']);
            $table->index(['skill_level', 'status']);
            $table->index(['performance_level', 'status']);
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
        Schema::dropIfExists('products_the_thao');
    }
};