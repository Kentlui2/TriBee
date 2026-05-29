<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->text('address');
            $table->string('zip_code', 10);
            $table->string('courier', 100)->nullable();
            $table->string('tracking_no', 100)->nullable();
            $table->enum('status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('tracking_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};