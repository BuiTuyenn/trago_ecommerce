<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_giay_dep_nu', function (Blueprint $table) {
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
            
            // Footwear specific fields
            $table->string('brand');
            $table->string('shoe_type'); // heels, flats, sneakers, boots, sandals
            $table->json('available_sizes'); // [35, 36, 37, 38, 39, 40]
            $table->string('material'); // leather, canvas, synthetic
            $table->string('sole_material'); // rubber, leather, foam
            $table->string('color');
            $table->json('available_colors')->nullable();
            $table->string('heel_height')->nullable(); // flat, low, mid, high
            $table->string('closure_type')->nullable(); // lace, slip-on, buckle, zip
            $table->string('toe_shape')->nullable(); // pointed, round, square
            $table->boolean('waterproof')->default(false);
            $table->string('season')->nullable(); // spring, summer, fall, winter
            $table->json('occasions')->nullable(); // casual, formal, party, work
            
            // Category & Media
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();

            // Indexes
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->index(['brand', 'status']);
            $table->index(['shoe_type', 'status']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_giay_dep_nu');
    }
};