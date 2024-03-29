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
        Schema::create('orders_has_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id')->references("id")->on("orders");
            $table->foreignId('products_id')->references("id")->on("products");
            $table->integer('quantity') -> default(1); 
            $table->timestamps();
            $table->index(['orders_id', 'products_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_has_products');
    }
};
