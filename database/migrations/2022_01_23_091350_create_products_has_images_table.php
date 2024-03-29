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
        Schema::create('products_has_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('images_id')->references("id")->on("images");
            $table->foreignId('products_id')->references("id")->on("products");
            $table->timestamps();
            $table->index(['images_id', 'products_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_has_images');
    }
};
