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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id()->nullable();
            $table->string('address');
            $table->string('tax_code')->nullable();
            $table->string('country')->nullable();
            $table->string('telephone_number')->nullable();
            $table->foreignId('users_id')->constrained()->references("id")->on("users")->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
