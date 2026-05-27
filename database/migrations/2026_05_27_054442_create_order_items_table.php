<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // order_items table
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();

            $table->string('product_name');        // snapshot — survives product edits/deletes
            $table->decimal('price', 10, 2);       // unit price at time of purchase
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);    // price * quantity

            $table->timestamps();
        });
    }
};
