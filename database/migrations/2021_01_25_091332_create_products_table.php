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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');// string limite laravel 250
            $table->text('description');// se supone que sin limite
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('developer');
            $table->string('publisher');
            $table->string('platform');
            $table->foreignId('reviews_id')->nullable()->references("id")->on("reviews");
            //->onDelete(DB::raw('NO ACTION')) RARETE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
