<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_xe_co', function (Blueprint $table) {
            $table->id();
            
            // Basic product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            
            // Pricing
            $table->decimal('price', 12, 2); // Vehicle prices can be high
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Vehicle specific fields
            $table->string('brand'); // Honda, Toyota, BMW, etc.
            $table->string('model'); // Civic, Camry, X5, etc.
            $table->string('vehicle_type'); // car, motorcycle, bicycle, scooter
            $table->integer('year')->nullable(); // Manufacturing year
            $table->string('condition')->default('new'); // new, used, certified_pre_owned
            
            // Engine & Performance
            $table->string('engine_type')->nullable(); // petrol, diesel, electric, hybrid
            $table->string('engine_capacity')->nullable(); // 1.5L, 150cc, etc.
            $table->string('fuel_type')->nullable(); // gasoline, diesel, electric, hybrid
            $table->string('transmission')->nullable(); // manual, automatic, cvt
            $table->decimal('fuel_consumption', 5, 2)->nullable(); // L/100km
            $table->string('max_speed')->nullable(); // km/h
            $table->string('power')->nullable(); // HP or kW
            
            // Physical specs
            $table->string('body_type')->nullable(); // sedan, suv, hatchback, cruiser
            $table->integer('seats')->nullable(); // Number of seats
            $table->integer('doors')->nullable(); // Number of doors
            $table->string('color');
            $table->json('available_colors')->nullable();
            $table->string('dimensions')->nullable(); // LxWxH
            $table->decimal('weight', 8, 2)->nullable(); // kg
            
            // Features & Equipment
            $table->json('features')->nullable(); // ABS, airbags, GPS, etc.
            $table->json('safety_features')->nullable();
            $table->json('comfort_features')->nullable();
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('power_steering')->default(false);
            $table->boolean('electric_windows')->default(false);
            
            // Legal & Documentation
            $table->string('license_plate')->nullable(); // For used vehicles
            $table->string('registration_number')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('last_service_date')->nullable();
            $table->integer('mileage')->nullable(); // km
            
            // Location & Contact
            $table->string('location_city')->nullable();
            $table->string('location_district')->nullable();
            $table->string('seller_type')->default('dealer'); // dealer, individual
            $table->string('contact_phone')->nullable();
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->json('videos')->nullable();
            $table->string('inspection_report')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'sold', 'reserved'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('certified')->default(false);
            $table->boolean('financing_available')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'model', 'status']);
            $table->index(['vehicle_type', 'status']);
            $table->index(['year', 'status']);
            $table->index(['location_city', 'status']);
            $table->fullText(['name', 'brand', 'model', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_xe_co');
    }
};