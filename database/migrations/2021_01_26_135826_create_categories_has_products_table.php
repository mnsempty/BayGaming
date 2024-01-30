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
        Schema::create('categories_has_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categories_id')->references("id")->on("categories")->unique();
            $table->foreignId('products_id')->references("id")->on("products")->unique();
            $table->timestamps();
            $table->index(['categories_id', 'products_id'])->unique();
            //unique(['categories_id', 'products_id'])
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_has_products');
    }
};
