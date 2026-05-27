<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // orders table
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('subtotal', 10, 2);               // raw cart total before anything
            $table->decimal('discount', 10, 2)->default(0);   // PricingEngine discounts
            $table->decimal('tax', 10, 2)->default(0);        // 12% VAT from PricingEngine
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);                  // final amount customer pays

            $table->enum('status', [
                'pending',
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->string('shipping_address')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
};
