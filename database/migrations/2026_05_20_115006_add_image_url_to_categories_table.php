<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // TASK ASSIGNMENT: MEMBER 1 (Billiones - Frontend Storefront Integration)
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Adds a nullable image string field to store URLs safely
            $table->string('image_url')->nullable()->after('slug');
        });
    }
// TASK ASSIGNMENT: MEMBER 1 (Billiones - Frontend Storefront Integration)
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};