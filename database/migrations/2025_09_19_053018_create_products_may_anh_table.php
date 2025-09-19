<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_may_anh', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 12, 2); // Cameras can be very expensive
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Camera specific fields
            $table->string('brand'); // Canon, Nikon, Sony, Fujifilm
            $table->string('model');
            $table->string('camera_type'); // DSLR, mirrorless, compact, action, instant
            $table->string('sensor_type'); // full_frame, aps_c, micro_four_thirds
            $table->decimal('sensor_size', 4, 1)->nullable(); // megapixels
            
            // Image specs
            $table->integer('max_resolution_mp'); // megapixels
            $table->string('max_image_resolution'); // 6000x4000
            $table->json('image_formats'); // ["JPEG", "RAW", "HEIF"]
            $table->string('color_depth')->nullable(); // 14-bit, 16-bit
            $table->integer('iso_range_min')->default(100);
            $table->integer('iso_range_max')->default(6400);
            
            // Video capabilities
            $table->boolean('video_recording')->default(true);
            $table->string('max_video_resolution')->nullable(); // 4K, 8K, FHD
            $table->string('video_frame_rates')->nullable(); // 30fps, 60fps, 120fps
            $table->json('video_formats')->nullable(); // ["MP4", "MOV", "AVCHD"]
            $table->boolean('image_stabilization')->default(false);
            $table->string('stabilization_type')->nullable(); // optical, digital, hybrid
            
            // Lens & Focus
            $table->string('lens_mount')->nullable(); // EF, RF, E-mount, F-mount
            $table->boolean('interchangeable_lens')->default(false);
            $table->string('kit_lens')->nullable(); // 18-55mm included
            $table->string('focus_system')->nullable(); // phase_detection, contrast
            $table->integer('focus_points')->nullable();
            $table->boolean('face_detection')->default(false);
            $table->boolean('eye_detection')->default(false);
            
            // Performance
            $table->decimal('continuous_shooting_fps', 3, 1)->nullable(); // 10.0 fps
            $table->integer('buffer_capacity')->nullable(); // shots in burst
            $table->string('shutter_speed_range')->nullable(); // 1/4000s - 30s
            $table->decimal('startup_time', 3, 2)->nullable(); // seconds
            
            // Display & Viewfinder
            $table->decimal('lcd_size', 2, 1)->nullable(); // 3.2 inches
            $table->string('lcd_resolution')->nullable(); // 1.04M dots
            $table->boolean('touchscreen')->default(false);
            $table->boolean('articulating_screen')->default(false);
            $table->boolean('electronic_viewfinder')->default(false);
            $table->string('viewfinder_resolution')->nullable();
            
            // Storage & Battery
            $table->json('memory_card_types'); // ["SD", "CF", "XQD"]
            $table->integer('memory_card_slots')->default(1);
            $table->string('battery_type');
            $table->integer('battery_life_shots')->nullable(); // CIPA rating
            $table->boolean('usb_charging')->default(false);
            
            // Connectivity
            $table->boolean('wifi')->default(false);
            $table->boolean('bluetooth')->default(false);
            $table->boolean('gps')->default(false);
            $table->json('ports')->nullable(); // ["USB-C", "HDMI", "3.5mm"]
            $table->boolean('wireless_flash')->default(false);
            
            // Physical specs
            $table->string('dimensions'); // WxHxD mm
            $table->decimal('weight', 6, 1); // grams
            $table->string('build_material')->nullable(); // magnesium_alloy, plastic
            $table->boolean('weather_sealed')->default(false);
            $table->string('color')->default('black');
            $table->json('available_colors')->nullable();
            
            // Professional features
            $table->boolean('dual_pixel_af')->default(false);
            $table->boolean('in_body_stabilization')->default(false);
            $table->json('creative_modes')->nullable(); // art filters, scenes
            $table->boolean('time_lapse')->default(false);
            $table->boolean('intervalometer')->default(false);
            $table->boolean('focus_stacking')->default(false);
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->json('sample_photos')->nullable(); // Sample images taken with camera
            $table->string('user_manual')->nullable();
            
            // Accessories & Kit
            $table->json('included_accessories')->nullable();
            $table->json('optional_accessories')->nullable();
            $table->boolean('lens_included')->default(false);
            $table->string('kit_type')->nullable(); // body_only, single_lens, dual_lens
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'discontinued'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('professional_grade')->default(false);
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
            $table->index(['camera_type', 'status']);
            $table->index(['sensor_type', 'status']);
            $table->index(['max_resolution_mp', 'status']);
            $table->index(['price', 'status']);
            $table->fullText(['name', 'brand', 'model', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_may_anh');
    }
};