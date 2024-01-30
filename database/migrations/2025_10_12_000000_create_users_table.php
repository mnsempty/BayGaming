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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->foreignId('addresses_id')->constrained()->nullable()->references("id")->on("addresses");
            $table->foreignId('wishlists_id')->constrained()->nullable()->references("id")->on("wishlists");
            $table->foreignId('reviews_id')->constrained()->nullable()->references("id")->on("reviews");
            $table->foreignId('orders_id')->constrained()->nullable()->references("id")->on("orders");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
