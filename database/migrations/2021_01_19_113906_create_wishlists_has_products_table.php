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
        Schema::create('wishlists_has_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wishlists_id')->references("id")->on("wishlists");
            $table->foreignId('products_id')->references("id")->on("products");
            $table->timestamps();
            $table->index(['wishlists_id', 'products_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists_has_products');
    }
};
