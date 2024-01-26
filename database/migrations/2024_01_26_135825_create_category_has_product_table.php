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
        Schema::create('category_has_product', function (Blueprint $table) {
            $table->id('category_has_product');
            $table->foreignId('category_id')->references("id")->on("categories");
            $table->foreignId('product_id')->references("id")->on("products");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_has_product');
    }
};