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
            $table->unsignedBigInteger('cart_id'); // Cambiado de integer a unsignedBigInteger
            $table->unsignedBigInteger('product_id'); // Cambiado de integer a unsignedBigInteger
            $table->unsignedBigInteger('discount_id')->nullable(); // Asegúrate de que 'discounts.id' también es unsignedBigInteger
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
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
