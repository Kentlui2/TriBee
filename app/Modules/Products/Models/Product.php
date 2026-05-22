<?php

declare(strict_types=1);

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Entity: Product
// Managed by: Member 5 Norhalija (Database & Schema Integrity)

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'name', 
        'brand', 
        'description', 
        'price', 
        'slug',
        'images',
        'specifications'
    ];

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}