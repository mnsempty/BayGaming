<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts_has_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carts_id')->references('id')->on('carts');
            $table->foreignId('products_id')->references('id')->on('products');
            $table->timestamps();

            $table->index(['carts_id', 'products_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_has_product');
    }
};
