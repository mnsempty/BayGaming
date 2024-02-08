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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            //$table->string('invoice_number');
            $table->date('date');
            // $table->date('due_date');
            $table->decimal('subtotal', 8, 2);
            // $table->decimal('tax', 8, 2);
            $table->foreignId('orders_id')->references("id")->on("orders");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
