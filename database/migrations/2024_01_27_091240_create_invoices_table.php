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
            $table->timestamps();
        });
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references("id")->on("orders");
            // $table->string('invoice_number');
            $table->date('date');
            // $table->date('due_date');
            // $table->enum('status', ['pending', 'paid']);
             $table->decimal('subtotal', 8, 2);
            // $table->decimal('tax', 8, 2);
            // $table->string('payment_method');
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
