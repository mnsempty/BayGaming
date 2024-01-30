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
        Schema::create('cart_has_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->references("id")->on("carts");
            $table->foreignId('product_id')->references("id")->on("products");
            $table->index(['cart_id', 'product_id']); //->unique(); yes or no??

            $table->timestamps();
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
