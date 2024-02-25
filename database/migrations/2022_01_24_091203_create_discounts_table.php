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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('percent')->default(0); // porcentaje a descontar
            $table->string('code')->unique(); // codigo para activar el descuento
            $table->boolean('active')->default(true); // el descuento está activo o no
            $table->integer('uses')->default(0); // cantidad de veces usado este descuento
            $table->date('expire_date')->nullable(); // fecha de caducidad del descuento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
