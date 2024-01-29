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
            $table->foreignId('addresses_id')->constrained()->references("id")->on("addresses")->onDelete('cascade');//;clave forania tabla address
            $table->foreignId('wishlists_id')->constrained()->references("id")->on("wishlists")->onDelete('cascade');
            $table->foreignId('reviews_id')->constrained()->references("id")->on("reviews")->onDelete('cascade');
            $table->foreignId('orders_id')->constrained()->references("id")->on("orders")->onDelete('cascade');
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
