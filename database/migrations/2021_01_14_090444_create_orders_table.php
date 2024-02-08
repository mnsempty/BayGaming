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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['pending', 'processing','completed','cancelled'])->default('pending');
            $table->string('orderData',  1000)->default("texnull");
            $table->decimal('total',10,2);
            $table->foreignId('users_id')->constrained()->references("id")->on("users")->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
