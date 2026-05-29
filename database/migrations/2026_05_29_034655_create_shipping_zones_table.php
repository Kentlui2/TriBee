<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('zone_name', 100); // Metro Manila, North Luzon, etc.
            $table->string('zip_code_pattern', 100); // 1xxx, 2xxx, 3xxx, etc.
            $table->decimal('flat_rate', 10, 2);
            $table->integer('estimated_days')->default(3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};