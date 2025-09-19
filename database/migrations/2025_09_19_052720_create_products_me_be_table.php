<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products_me_be', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            
            // Specific fields
            $table->string('brand');
            $table->string('product_type'); // toy, clothing, feeding, safety, etc.
            $table->string('age_range'); // 0-6 months, 1-3 years, etc.
            $table->string('gender')->nullable(); // boy, girl, unisex
            $table->json('materials')->nullable();
            $table->json('safety_certifications')->nullable();
            $table->string('size')->nullable();
            $table->json('available_sizes')->nullable();
            $table->date('expiry_date')->nullable(); // for consumables
            $table->text('usage_instructions')->nullable();
            $table->boolean('organic')->default(false);
            $table->boolean('hypoallergenic')->default(false);
            
            $table->unsignedBigInteger('category_id');
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->boolean('featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['status', 'featured']);
            $table->fullText(['name', 'brand', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products_me_be');
    }
};