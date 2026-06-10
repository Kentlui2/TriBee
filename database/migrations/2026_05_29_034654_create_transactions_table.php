<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['deposit', 'purchase', 'refund']);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->string('reference_no', 50)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['user_id', 'created_at']);
            $table->index('reference_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};