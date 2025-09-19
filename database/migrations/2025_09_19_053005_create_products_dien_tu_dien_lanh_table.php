<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_dien_tu_dien_lanh', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 12, 2); // Electronics can be expensive
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Electronics specific fields
            $table->string('brand'); // Samsung, LG, Sony, Panasonic
            $table->string('model')->nullable();
            $table->string('product_type'); // TV, refrigerator, air_conditioner, washing_machine
            $table->string('display_technology')->nullable(); // LED, OLED, QLED (for TVs)
            $table->string('screen_size')->nullable(); // 55", 65" (for TVs)
            $table->string('resolution')->nullable(); // 4K, 8K, Full HD
            
            // Power & Energy
            $table->string('power_consumption')->nullable(); // Watts
            $table->string('energy_rating')->nullable(); // A++, A+, B, C
            $table->string('voltage')->nullable(); // 220V
            $table->string('frequency')->nullable(); // 50Hz
            
            // Physical specifications
            $table->string('dimensions'); // WxDxH cm
            $table->decimal('weight', 8, 2)->nullable(); // kg
            $table->string('color');
            $table->json('available_colors')->nullable();
            $table->string('installation_type')->nullable(); // wall_mount, standing, built_in
            
            // Capacity & Performance (for appliances)
            $table->string('capacity')->nullable(); // 450L (fridge), 9kg (washing machine)
            $table->string('cooling_capacity')->nullable(); // BTU for AC
            $table->string('defrost_type')->nullable(); // manual, auto (for fridges)
            $table->integer('temperature_zones')->nullable(); // for fridges
            $table->string('wash_programs')->nullable(); // for washing machines
            $table->string('spin_speed')->nullable(); // RPM for washing machines
            
            // Smart Features
            $table->boolean('smart_tv')->default(false);
            $table->boolean('wifi_enabled')->default(false);
            $table->boolean('bluetooth')->default(false);
            $table->json('smart_features')->nullable(); // voice control, app control
            $table->json('connectivity_ports')->nullable(); // HDMI, USB, etc.
            $table->string('operating_system')->nullable(); // Android TV, Tizen, webOS
            
            // Audio & Video (for entertainment devices)
            $table->string('audio_output')->nullable(); // Dolby Atmos, DTS
            $table->json('supported_formats')->nullable(); // video/audio formats
            $table->boolean('hdr_support')->default(false);
            $table->integer('refresh_rate')->nullable(); // Hz for TVs
            
            // Features & Technology
            $table->json('features')->nullable();
            $table->json('included_accessories')->nullable();
            $table->boolean('inverter_technology')->default(false);
            $table->boolean('eco_mode')->default(false);
            $table->string('noise_level')->nullable(); // dB
            
            // Installation & Service
            $table->boolean('requires_installation')->default(false);
            $table->decimal('installation_fee', 8, 2)->nullable();
            $table->boolean('free_delivery')->default(false);
            $table->json('service_areas')->nullable();
            
            // Warranty & Support
            $table->integer('warranty_months')->default(24); // Usually longer for appliances
            $table->string('warranty_type')->nullable(); // manufacturer, extended
            $table->boolean('on_site_service')->default(false);
            $table->string('service_hotline')->nullable();
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('user_manual')->nullable();
            $table->string('energy_guide')->nullable(); // Energy consumption guide
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('energy_efficient')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['product_type', 'status']);
            $table->index(['energy_rating', 'status']);
            $table->index(['price', 'status']);
            $table->fullText(['name', 'brand', 'model', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_dien_tu_dien_lanh');
    }
};