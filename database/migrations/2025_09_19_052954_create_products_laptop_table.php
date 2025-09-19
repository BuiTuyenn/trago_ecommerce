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
        Schema::create('products_laptop', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 12, 2); // Laptop prices can be high
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Laptop specific fields
            $table->string('brand'); // Dell, HP, Apple, Lenovo, Asus, etc.
            $table->string('model'); // XPS 13, MacBook Pro, ThinkPad X1
            $table->string('series')->nullable(); // Gaming, Business, Ultrabook
            $table->string('laptop_type'); // ultrabook, gaming, workstation, 2-in-1
            $table->string('target_user'); // student, professional, gamer, creator
            
            // Display specifications
            $table->decimal('screen_size', 3, 1); // 13.3, 15.6, 17.3 inches
            $table->string('screen_resolution'); // 1920x1080, 2560x1600, 3840x2160
            $table->string('display_type'); // IPS, OLED, TN, VA
            $table->integer('refresh_rate')->default(60); // 60Hz, 120Hz, 144Hz
            $table->integer('brightness_nits')->nullable(); // 300, 400, 500 nits
            $table->boolean('touchscreen')->default(false);
            $table->string('aspect_ratio')->default('16:9'); // 16:9, 16:10, 3:2
            $table->string('color_gamut')->nullable(); // sRGB, Adobe RGB, DCI-P3
            
            // Performance specifications
            $table->string('processor'); // Intel Core i7-12700H, AMD Ryzen 7 6800H
            $table->string('processor_generation')->nullable(); // 12th Gen, Ryzen 6000
            $table->decimal('base_clock_ghz', 3, 2)->nullable(); // 2.40 GHz
            $table->decimal('boost_clock_ghz', 3, 2)->nullable(); // 4.70 GHz
            $table->integer('cores')->nullable(); // 8 cores
            $table->integer('threads')->nullable(); // 16 threads
            
            // Memory & Storage
            $table->integer('ram_gb'); // 8, 16, 32, 64 GB
            $table->string('ram_type'); // DDR4, DDR5, LPDDR5
            $table->integer('ram_speed_mhz')->nullable(); // 3200MHz, 4800MHz
            $table->boolean('ram_upgradeable')->default(true);
            $table->integer('max_ram_gb')->nullable(); // Maximum upgradeable RAM
            
            $table->integer('storage_gb'); // 256, 512, 1024, 2048 GB
            $table->string('storage_type'); // SSD, HDD, eMMC, NVMe SSD
            $table->json('storage_configuration')->nullable(); // Multiple drives info
            $table->boolean('storage_upgradeable')->default(true);
            $table->integer('available_slots')->nullable(); // Additional storage slots
            
            // Graphics
            $table->string('graphics_card'); // Intel Iris Xe, NVIDIA RTX 4060, AMD Radeon
            $table->string('graphics_type'); // integrated, dedicated
            $table->integer('vram_gb')->nullable(); // 4, 6, 8 GB for dedicated cards
            $table->boolean('ray_tracing')->default(false);
            $table->boolean('dlss_support')->default(false);
            
            // Design & Build
            $table->string('dimensions'); // 307 x 213 x 16.9 mm
            $table->decimal('weight_kg', 3, 2); // 1.25 kg
            $table->string('build_material'); // aluminum, plastic, carbon fiber
            $table->string('color'); // silver, black, gold, etc.
            $table->json('available_colors')->nullable();
            $table->string('keyboard_type'); // membrane, mechanical, butterfly
            $table->boolean('backlit_keyboard')->default(false);
            $table->boolean('numeric_keypad')->default(false);
            $table->string('trackpad_size')->nullable(); // large, medium, small
            
            // Battery & Power
            $table->integer('battery_whr')->nullable(); // 56Wh, 86Wh
            $table->string('battery_life_hours')->nullable(); // "up to 10 hours"
            $table->integer('power_adapter_w'); // 65W, 90W, 180W
            $table->string('charging_port'); // USB-C, proprietary
            $table->boolean('fast_charging')->default(false);
            
            // Connectivity & Ports
            $table->json('ports')->nullable(); // ["USB-A 3.2", "USB-C", "HDMI", "SD Card"]
            $table->integer('usb_a_ports')->default(0);
            $table->integer('usb_c_ports')->default(0);
            $table->boolean('thunderbolt_support')->default(false);
            $table->string('thunderbolt_version')->nullable(); // Thunderbolt 4
            $table->boolean('hdmi_port')->default(false);
            $table->string('hdmi_version')->nullable(); // HDMI 2.1
            $table->boolean('ethernet_port')->default(false);
            $table->boolean('sd_card_slot')->default(false);
            $table->boolean('headphone_jack')->default(true);
            
            // Wireless connectivity
            $table->string('wifi_standard'); // Wi-Fi 6E, Wi-Fi 6, Wi-Fi 5
            $table->string('bluetooth_version'); // 5.2, 5.3
            $table->boolean('cellular_support')->default(false);
            $table->string('cellular_type')->nullable(); // 4G LTE, 5G
            
            // Operating System
            $table->string('operating_system'); // Windows 11, macOS, Linux
            $table->string('os_version')->nullable(); // Windows 11 Pro, macOS Ventura
            $table->boolean('os_included')->default(true);
            
            // Security features
            $table->boolean('fingerprint_scanner')->default(false);
            $table->boolean('face_recognition')->default(false);
            $table->boolean('tpm_chip')->default(false);
            $table->string('security_features')->nullable(); // Intel vPro, etc.
            
            // Audio & Camera
            $table->json('speakers')->nullable(); // ["stereo", "quad speakers"]
            $table->string('audio_brand')->nullable(); // Bang & Olufsen, Harman Kardon
            $table->boolean('webcam')->default(true);
            $table->string('webcam_resolution')->nullable(); // 720p, 1080p, 4K
            $table->boolean('webcam_privacy_shutter')->default(false);
            $table->json('microphones')->nullable(); // ["dual array", "noise canceling"]
            
            // Category & Usage
            $table->unsignedBigInteger('category_id');
            $table->json('use_cases')->nullable(); // ["gaming", "productivity", "content_creation"]
            $table->json('software_included')->nullable(); // Pre-installed software
            $table->string('gaming_performance')->nullable(); // entry, mid-range, high-end
            
            // Warranty & Support
            $table->integer('warranty_years')->default(1);
            $table->string('warranty_type')->nullable(); // international, local
            $table->boolean('accidental_damage_protection')->default(false);
            $table->string('support_hotline')->nullable();
            
            // Media
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('specifications_pdf')->nullable();
            $table->json('benchmark_scores')->nullable(); // Performance benchmarks
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft', 'discontinued', 'pre_order'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->boolean('business_laptop')->default(false);
            $table->boolean('gaming_laptop')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['laptop_type', 'status']);
            $table->index(['processor', 'status']);
            $table->index(['ram_gb', 'status']);
            $table->index(['storage_gb', 'status']);
            $table->index(['price', 'status']);
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
        Schema::dropIfExists('products_laptop');
    }
};