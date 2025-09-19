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
        Schema::create('products_dien_thoai', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 12, 2); // Giá điện thoại có thể cao
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Phone/Tablet specific fields
            $table->string('brand'); // Apple, Samsung, Xiaomi, etc.
            $table->string('model'); // iPhone 15 Pro, Galaxy S24, etc.
            $table->string('device_type'); // smartphone, tablet, smartwatch
            $table->string('operating_system'); // iOS, Android, HarmonyOS
            $table->string('os_version')->nullable(); // iOS 17, Android 14
            
            // Display specifications
            $table->decimal('screen_size', 3, 1)->nullable(); // 6.1 inch
            $table->string('screen_resolution')->nullable(); // 1170x2532
            $table->string('screen_technology')->nullable(); // OLED, AMOLED, LCD
            $table->integer('refresh_rate')->nullable(); // 120Hz
            $table->integer('brightness_nits')->nullable(); // 1000 nits
            $table->boolean('hdr_support')->default(false);
            
            // Performance
            $table->string('processor'); // A17 Pro, Snapdragon 8 Gen 3
            $table->string('gpu')->nullable(); // GPU model
            $table->integer('ram_gb'); // 8GB, 12GB
            $table->json('storage_options'); // [128, 256, 512, 1024]
            $table->integer('storage_gb'); // Actual storage of this variant
            $table->boolean('expandable_storage')->default(false);
            $table->string('storage_type')->nullable(); // UFS 4.0, etc.
            
            // Camera specifications
            $table->json('rear_cameras')->nullable(); // [{"mp": 48, "type": "main"}, {"mp": 12, "type": "ultra-wide"}]
            $table->integer('front_camera_mp')->nullable(); // 12MP
            $table->json('camera_features')->nullable(); // Night mode, Portrait, etc.
            $table->boolean('video_recording_4k')->default(false);
            $table->string('video_recording_fps')->nullable(); // 60fps, 120fps
            
            // Battery & Charging
            $table->integer('battery_capacity_mah')->nullable(); // 3274mAh
            $table->string('charging_speed')->nullable(); // 20W, 67W
            $table->boolean('wireless_charging')->default(false);
            $table->boolean('reverse_charging')->default(false);
            $table->string('charging_port'); // Lightning, USB-C
            
            // Connectivity
            $table->json('network_support'); // ["5G", "4G LTE", "3G"]
            $table->boolean('dual_sim')->default(false);
            $table->boolean('esim_support')->default(false);
            $table->boolean('wifi_6')->default(false);
            $table->boolean('bluetooth')->default(true);
            $table->string('bluetooth_version')->nullable(); // 5.3
            $table->boolean('nfc')->default(false);
            $table->boolean('infrared')->default(false);
            
            // Security & Biometrics
            $table->json('biometric_features')->nullable(); // ["Face ID", "Touch ID", "Fingerprint"]
            $table->boolean('face_unlock')->default(false);
            $table->boolean('fingerprint_scanner')->default(false);
            $table->string('fingerprint_location')->nullable(); // under-display, side, back
            
            // Physical specifications
            $table->string('dimensions')->nullable(); // 146.7 x 71.5 x 7.8 mm
            $table->decimal('weight_grams', 5, 1)->nullable(); // 174.0g
            $table->string('build_material')->nullable(); // Aluminum, Glass, Plastic
            $table->string('color'); // Current variant color
            $table->json('available_colors')->nullable(); // All available colors
            $table->string('water_resistance')->nullable(); // IP68, IP67
            
            // Audio features
            $table->boolean('headphone_jack')->default(false);
            $table->json('speakers')->nullable(); // ["stereo", "dolby_atmos"]
            $table->boolean('noise_cancellation')->default(false);
            
            // Additional features
            $table->json('sensors')->nullable(); // ["accelerometer", "gyroscope", "proximity"]
            $table->json('special_features')->nullable(); // ["MagSafe", "S Pen", "Always On Display"]
            $table->boolean('gaming_mode')->default(false);
            $table->string('cooling_system')->nullable(); // Vapor chamber, etc.
            
            // Category & Warranty
            $table->unsignedBigInteger('category_id');
            $table->integer('warranty_months')->default(12);
            $table->string('warranty_type')->nullable(); // International, Local
            $table->string('origin_country')->nullable(); // China, USA, South Korea
            
            // Condition & Availability
            $table->string('condition')->default('new'); // new, refurbished, used
            $table->date('release_date')->nullable(); // Official release date
            $table->boolean('unlocked')->default(true); // Carrier unlocked
            $table->json('compatible_carriers')->nullable(); // Compatible networks
            
            // Package contents
            $table->json('box_contents')->nullable(); // ["Phone", "USB Cable", "Adapter"]
            $table->boolean('charger_included')->default(true);
            $table->boolean('earphones_included')->default(false);
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('user_manual')->nullable(); // PDF link
            $table->json('comparison_charts')->nullable(); // Comparison images
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'discontinued', 'pre_order'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('limited_edition')->default(false);
            $table->boolean('flagship')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['device_type', 'status']);
            $table->index(['operating_system', 'status']);
            $table->index(['price', 'status']);
            $table->index(['release_date', 'status']);
            $table->fullText(['name', 'brand', 'model', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_dien_thoai');
    }
};