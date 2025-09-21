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
        Schema::create('browse_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->string('product_slug');
            $table->decimal('product_price', 10, 2);
            $table->string('product_image')->nullable();
            $table->integer('view_count')->default(1);
            $table->timestamp('last_viewed_at');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['user_id', 'last_viewed_at']);
            $table->index(['session_id', 'last_viewed_at']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('browse_histories');
    }
};
